<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Payment;
use App\Services\KopoKopoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_city' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:1000',
            'payment_method' => 'required|in:mpesa,cash_on_delivery,credit_card,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get cart items
        $cartItems = Cart::where('session_id', session()->getId())
            ->with(['product', 'bundle'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        if ($validated['payment_method'] === 'mpesa') {
            session()->forget('pending_mpesa_order_id');
            session(['pending_mpesa_checkout' => [
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_city' => $validated['customer_city'],
                'delivery_address' => $validated['delivery_address'],
                'notes' => $validated['notes'] ?? null,
            ]]);

            return redirect()->route('checkout.mpesa');
        }

        session()->forget('pending_mpesa_checkout');
        session()->forget('pending_mpesa_order_id');

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            if ($item->bundle_id) {
                return $item->bundle->price * $item->quantity;
            } else {
                return $item->product->price * $item->quantity;
            }
        });

        $tax = $subtotal * 0.15; // 15% tax
        $shipping = $this->calculateShipping($request->customer_city, $subtotal);
        $total = $subtotal + $tax + $shipping;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => [
                'street' => $request->delivery_address,
                'city' => $request->customer_city,
                'state' => 'N/A',
                'zip_code' => 'N/A',
                'country' => 'N/A'
            ],
            'billing_address' => [
                'street' => $request->delivery_address,
                'city' => $request->customer_city,
                'state' => 'N/A',
                'zip_code' => 'N/A',
                'country' => 'N/A'
            ],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shipping,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Create order items and increment sold counts
        foreach ($cartItems as $cartItem) {
            if ($cartItem->bundle_id) {
                // Create order item for bundle
                OrderItem::create([
                    'order_id' => $order->id,
                    'bundle_id' => $cartItem->bundle_id,
                    'bundle_name' => $cartItem->bundle->name,
                    'bundle_price' => $cartItem->bundle->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->bundle->price * $cartItem->quantity,
                ]);
                
                // Increment bundle sold count
                $cartItem->bundle->increment('sold_count', $cartItem->quantity);
            } else {
                // Create order item for individual product
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                    'selected_size' => $cartItem->selected_size,
                ]);
                
                // Increment product sold count
                $cartItem->product->increment('sold_count', $cartItem->quantity);

            }
        }

        Payment::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'cart_session_id' => $request->session()->getId(),
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'phone' => $order->customer_phone,
            'method' => $order->payment_method,
            'provider' => 'manual',
            'source' => 'storefront',
            'amount' => $order->total,
            'currency' => 'KES',
            'status' => 'pending',
            'metadata' => ['order_number' => $order->order_number],
        ]);

        // Clear cart
        Cart::where('session_id', session()->getId())->delete();

        // Send admin email notification
        $this->sendAdminOrderNotification($order);

        // Send customer email notification
        try {
            Mail::to($order->customer_email)->send(new \App\Mail\OrderPlacedCustomer($order));
        } catch (Throwable) {
            Log::warning('Failed to send customer order notification.', ['order_id' => $order->id]);
        }

        // Send WhatsApp notification to admin
        try {
            $adminPhone = \App\Models\Setting::get('contact_phone_primary', '0726243706');
            $total = number_format($order->total);
            
            $message = "Hello Mars Collection, a new order *#{$order->order_number}* just happened by *{$order->customer_name}* for *KES {$total}*. Please check the admin panel to process.";
            
            \App\Services\WhatsAppService::sendMessage($adminPhone, $message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send order WhatsApp notification: ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        // Just show a generic success message without any order details
        return view('checkout.success');
    }

    public function showMpesaCheckout(Request $request)
    {
        $checkoutDetails = $request->session()->get('pending_mpesa_checkout');
        if (!$checkoutDetails) {
            return redirect()->route('cart.index')->with('error', 'Enter your delivery details to continue with M-Pesa.');
        }

        $cartItems = Cart::where('session_id', $request->session()->getId())
            ->with(['product', 'bundle'])
            ->get();
        if ($cartItems->isEmpty()) {
            $request->session()->forget('pending_mpesa_checkout');
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->bundle_id
            ? $item->bundle->price * $item->quantity
            : $item->product->price * $item->quantity);
        $tax = $subtotal * 0.15;
        $shipping = $this->calculateShipping($checkoutDetails['customer_city'], $subtotal);
        $total = $subtotal + $tax + $shipping;

        $kopokopoConfigured = app(KopoKopoService::class)->isConfigured();

        return view('checkout.mpesa', compact('cartItems', 'checkoutDetails', 'subtotal', 'tax', 'shipping', 'total', 'kopokopoConfigured'));
    }

    public function prepareMpesaStk(Request $request)
    {
        $request->merge([
            'phone' => preg_replace('/[\\s()-]/', '', (string) $request->input('phone', '')),
        ]);

        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20', 'regex:/^(?:\\+?254|0)?[17]\\d{8}$/'],
        ], [
            'phone.regex' => 'Enter a valid Kenyan Safaricom number, for example 0712 345 678 or +254 712 345 678.',
        ]);

        $checkoutDetails = $request->session()->get('pending_mpesa_checkout');
        if (!$checkoutDetails) {
            return redirect()->route('cart.index')->with('error', 'Your checkout session expired. Please try again.');
        }

        $checkoutDetails['customer_phone'] = $validated['phone'];
        $request->session()->put('pending_mpesa_checkout', $checkoutDetails);

        $cartItems = Cart::where('session_id', $request->session()->getId())
            ->with(['product', 'bundle'])
            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->bundle_id
            ? $item->bundle->price * $item->quantity
            : $item->product->price * $item->quantity);
        $tax = $subtotal * 0.15;
        $shipping = $this->calculateShipping($checkoutDetails['customer_city'], $subtotal);
        $total = $subtotal + $tax + $shipping;
        $orderId = $request->session()->get('pending_mpesa_order_id');
        $order = $orderId ? Order::whereKey($orderId)->where('status', 'pending')->first() : null;

        [$order, $payment] = DB::transaction(function () use ($request, $checkoutDetails, $cartItems, $subtotal, $tax, $shipping, $total, $order) {
            if (!$order) {
                $order = Order::create([
                    'order_number' => 'ORD-' . Str::upper(Str::random(8)),
                    'user_id' => auth()->id(),
                    'customer_name' => $checkoutDetails['customer_name'],
                    'customer_email' => $checkoutDetails['customer_email'],
                    'customer_phone' => $checkoutDetails['customer_phone'],
                    'shipping_address' => [
                        'street' => $checkoutDetails['delivery_address'],
                        'city' => $checkoutDetails['customer_city'],
                        'state' => 'N/A', 'zip_code' => 'N/A', 'country' => 'Kenya',
                    ],
                    'billing_address' => [
                        'street' => $checkoutDetails['delivery_address'],
                        'city' => $checkoutDetails['customer_city'],
                        'state' => 'N/A', 'zip_code' => 'N/A', 'country' => 'Kenya',
                    ],
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping_cost' => $shipping,
                    'total' => $total,
                    'payment_method' => 'mpesa',
                    'notes' => $checkoutDetails['notes'],
                ]);

                foreach ($cartItems as $cartItem) {
                    if ($cartItem->bundle_id) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'bundle_id' => $cartItem->bundle_id,
                            'bundle_name' => $cartItem->bundle->name,
                            'bundle_price' => $cartItem->bundle->price,
                            'quantity' => $cartItem->quantity,
                            'subtotal' => $cartItem->bundle->price * $cartItem->quantity,
                        ]);
                        $cartItem->bundle->increment('sold_count', $cartItem->quantity);
                    } else {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'product_name' => $cartItem->product->name,
                            'product_price' => $cartItem->product->price,
                            'quantity' => $cartItem->quantity,
                            'subtotal' => $cartItem->product->price * $cartItem->quantity,
                            'selected_size' => $cartItem->selected_size,
                        ]);
                        $cartItem->product->increment('sold_count', $cartItem->quantity);
                    }
                }
            }

            $payment = Payment::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'reference' => 'PAY-' . Str::upper(Str::random(10)),
                'cart_session_id' => $request->session()->getId(),
                'customer_name' => $checkoutDetails['customer_name'],
                'customer_email' => $checkoutDetails['customer_email'],
                'phone' => $checkoutDetails['customer_phone'],
                'method' => 'mpesa',
                'provider' => 'kopokopo',
                'source' => 'storefront',
                'amount' => $total,
                'currency' => 'KES',
                'status' => 'pending',
                'metadata' => ['order_number' => $order->order_number],
            ]);

            return [$order, $payment];
        });

        $request->session()->put('pending_mpesa_order_id', $order->id);

        $kopokopo = app(KopoKopoService::class);
        if (!$kopokopo->isConfigured()) {
            $payment->update([
                'status' => 'setup_required',
                'failure_reason' => 'KopoKopo credentials are not configured.',
            ]);

            return redirect()->route('checkout.mpesa')->with('stk_pending', 'Payment request saved. KopoKopo is not configured yet, so no STK prompt was sent. Your order is saved as pending and your cart is still available.');
        }

        try {
            $fullName = preg_split('/\\s+/', trim($checkoutDetails['customer_name']), 2) ?: [];
            $localPhone = preg_replace('/\\D/', '', $validated['phone']);
            $e164Phone = str_starts_with($localPhone, '254') ? '+' . $localPhone
                : (str_starts_with($localPhone, '0') ? '+254' . substr($localPhone, 1) : '+254' . $localPhone);
            $result = $kopokopo->initiateIncomingPayment(
                $payment,
                $fullName[0] ?? $checkoutDetails['customer_name'],
                $fullName[1] ?? '-',
                $checkoutDetails['customer_email'],
                $e164Phone,
                'Order ' . $order->order_number
            );

            $payment->update([
                'status' => 'initiated',
                'provider_request_id' => $result['request_id'],
                'provider_request_url' => $result['request_url'],
            ]);

            return redirect()->route('checkout.mpesa.status', $payment->public_id);
        } catch (Throwable $exception) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'KopoKopo could not initiate this payment. Please try again.',
            ]);
            Log::warning('KopoKopo STK request failed.', ['payment_id' => $payment->id, 'order_id' => $order->id]);

            return redirect()->route('checkout.mpesa')->with('stk_pending', 'We could not send the STK prompt. No payment was taken. Please try again or choose another payment method.');
        }
    }

    public function showMpesaStatus(string $publicId)
    {
        $payment = Payment::with('order')->where('public_id', $publicId)->firstOrFail();

        return view('checkout.mpesa-status', compact('payment'));
    }

    private function calculateShipping($city, $subtotal = 0)
    {
        // Free delivery threshold configured in KES.
        if ($subtotal >= (int) config('shipping.free_delivery_threshold', 15000)) {
            return 0.00;
        }

        // Convert city to lowercase for comparison
        $city = strtolower(trim($city));
        
        // Local cities (free shipping)
        $localCities = [
            'nairobi', 'mombasa', 'kisumu', 'nakuru', 'eldoret', 'thika', 'kakamega', 'kericho'
        ];
        
        // Nearby cities (low shipping cost)
        $nearbyCities = [
            'naivasha', 'kerugoya', 'nyeri', 'muranga', 'kiambu', 'machakos', 'kitui', 'embu', 'meru'
        ];
        
        // Check if city is local (free shipping)
        if (in_array($city, $localCities)) {
            return 0.00;
        }
        
        // Check if city is nearby (low shipping cost)
        if (in_array($city, $nearbyCities)) {
            return 1500.00; // KES 1,500
        }
        
        // Default shipping cost for other cities
        return 2500.00; // KES 2,500
    }

    private function sendAdminOrderNotification(Order $order)
    {
        try {
            $adminEmail = \App\Helpers\SettingsHelper::getAdminEmail();
            Mail::send('emails.admin-order-notification', ['order' => $order], function ($message) use ($adminEmail, $order) {
                $message->to($adminEmail)
                        ->subject('New Order Received - ' . $order->order_number);
            });
        } catch (Throwable) {
            Log::warning('Failed to send admin order notification.', ['order_id' => $order->id]);
        }
    }
}
