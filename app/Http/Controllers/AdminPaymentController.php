<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\KopoKopoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('order')->latest();
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('search')) {
            $term = '%' . $request->string('search') . '%';
            $query->where(fn ($q) => $q->where('reference', 'like', $term)
                ->orWhere('customer_name', 'like', $term)
                ->orWhere('phone', 'like', $term)
                ->orWhere('provider_reference', 'like', $term));
        }

        $payments = $query->paginate(30)->withQueryString();
        $stats = [
            'all' => Payment::count(),
            'initiated' => Payment::where('status', 'initiated')->count(),
            'succeeded' => Payment::where('status', 'succeeded')->count(),
            'attention' => Payment::whereIn('status', ['failed', 'setup_required'])->count(),
        ];
        $openOrders = Order::where('status', 'pending')->latest()->limit(100)->get();
        $kopokopoConfigured = app(KopoKopoService::class)->isConfigured();

        return view('admin.payments.index', compact('payments', 'stats', 'openOrders', 'kopokopoConfigured'));
    }

    public function startStk(Request $request, KopoKopoService $kopokopo)
    {
        $request->merge(['phone' => preg_replace('/[\\s()-]/', '', (string) $request->input('phone', ''))]);
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'phone' => ['required', 'string', 'max:30', 'regex:/^(?:\\+?254|0)?[17]\\d{8}$/'],
            'amount' => 'required|numeric|min:1|max:10000000',
            'order_id' => 'nullable|integer|exists:orders,id',
            'notes' => 'nullable|string|max:255',
        ], ['phone.regex' => 'Enter a valid Kenyan mobile number.']);

        $phoneDigits = preg_replace('/\\D/', '', $validated['phone']);
        $phone = str_starts_with($phoneDigits, '254') ? '+' . $phoneDigits
            : (str_starts_with($phoneDigits, '0') ? '+254' . substr($phoneDigits, 1) : '+254' . $phoneDigits);
        $order = !empty($validated['order_id']) ? Order::findOrFail($validated['order_id']) : null;
        $amount = $order ? (float) $order->total : (float) $validated['amount'];

        $payment = Payment::create([
            'order_id' => $order?->id,
            'user_id' => auth()->id(),
            'customer_name' => $order?->customer_name ?? $validated['customer_name'],
            'customer_email' => $order?->customer_email ?? ($validated['customer_email'] ?? null),
            'phone' => $phone,
            'method' => 'mpesa',
            'provider' => 'kopokopo',
            'source' => 'admin_playground',
            'amount' => $amount,
            'currency' => 'KES',
            'status' => 'pending',
            'metadata' => array_filter([
                'order_number' => $order?->order_number,
                'notes' => $validated['notes'] ?? null,
            ]),
        ]);

        if (!$kopokopo->isConfigured()) {
            $payment->update([
                'status' => 'setup_required',
                'failure_reason' => 'KopoKopo credentials are not configured.',
            ]);

            return redirect()->route('admin.payments.index')->with('warning', 'Payment record saved. Add the KopoKopo credentials in the server environment before sending live or sandbox STK requests.');
        }

        try {
            $name = preg_split('/\\s+/', trim($payment->customer_name), 2) ?: [];
            $result = $kopokopo->initiateIncomingPayment(
                $payment,
                $name[0] ?? $payment->customer_name,
                $name[1] ?? '-',
                $payment->customer_email,
                $phone,
                $validated['notes'] ?? ('Admin STK test ' . $payment->reference)
            );
            $payment->update([
                'status' => 'initiated',
                'provider_request_id' => $result['request_id'],
                'provider_request_url' => $result['request_url'],
            ]);

            return redirect()->route('admin.payments.index')->with('success', "STK request sent to {$phone}. Payment reference: {$payment->reference}.");
        } catch (Throwable) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => 'The KopoKopo STK request could not be completed.',
            ]);
            Log::warning('Admin KopoKopo playground request failed.', ['payment_id' => $payment->id]);

            return redirect()->route('admin.payments.index')->with('error', 'The STK request failed. The attempt has been recorded; check the credentials and try again.');
        }
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,initiated,succeeded,failed,cancelled,refunded,setup_required',
            'admin_note' => 'nullable|string|max:1000',
        ]);
        if (in_array($validated['status'], ['succeeded', 'refunded'], true) && blank($validated['admin_note'] ?? null)) {
            return back()->withErrors(['admin_note' => 'Add a short reconciliation note for this status change.'])->withInput();
        }

        $metadata = $payment->metadata ?? [];
        $events = $metadata['admin_status_history'] ?? [];
        $events[] = [
            'from' => $payment->status,
            'to' => $validated['status'],
            'note' => $validated['admin_note'] ?? null,
            'by' => auth()->id(),
            'at' => now()->toIso8601String(),
        ];
        $metadata['admin_status_history'] = array_slice($events, -20);

        $payment->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? $payment->admin_note,
            'failure_reason' => $validated['status'] === 'failed' ? ($validated['admin_note'] ?? 'Marked failed by admin.') : null,
            'metadata' => $metadata,
        ]);

        if ($validated['status'] === 'succeeded' && $payment->order && $payment->order->status === 'pending') {
            $payment->order->update(['status' => 'processing']);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment record updated.');
    }
}
