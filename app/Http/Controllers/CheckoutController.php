<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_city' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:1000',
            'payment_method' => 'required|in:cash_on_delivery,credit_card,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get cart items
        $cartItems = Cart::where('session_id', session()->getId())
            ->with(['product', 'bundle'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            if ($item->bundle_id) {
                return $item->bundle->price * $item->quantity;
            } else {
                return $item->product->price * $item->quantity;
            }
        });

        $tax = $subtotal * 0.15; // 15% tax
        $shipping = $this->calculateShipping($request->customer_city);
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
                ]);
                
                // Increment product sold count
                $cartItem->product->increment('sold_count', $cartItem->quantity);
            }
        }

        // Clear cart
        Cart::where('session_id', session()->getId())->delete();

        // Send admin email notification
        $this->sendAdminOrderNotification($order);

        // Send customer email notification
        try {
            Mail::to($order->customer_email)->send(new \App\Mail\OrderPlacedCustomer($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send customer order notification: ' . $e->getMessage());
        }

        // Send WhatsApp notification to admin
        try {
            $adminPhone = \App\Models\Setting::get('contact_phone_primary', '254723343392');
            $total = number_format($order->total);
            
            $message = "Hello zayns, a new order *#{$order->order_number}* just happened by *{$order->customer_name}* for *KES {$total}*. Please check the admin panel to process.";
            
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

    private function calculateShipping($city)
    {
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
        $adminEmail = \App\Helpers\SettingsHelper::getAdminEmail();

        Mail::send('emails.admin-order-notification', ['order' => $order], function ($message) use ($adminEmail, $order) {
            $message->to($adminEmail)
                    ->subject('New Order Received - ' . $order->order_number);
        });
    }
}
