<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use App\Mail\OrderPlacedCustomer;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EconfirmPaymentFinalizer
{
    public function markFunded(Payment $payment, string $transactionId): bool
    {
        $newlyFunded = DB::transaction(function () use ($payment, $transactionId) {
            $lockedPayment = Payment::whereKey($payment->id)->lockForUpdate()->firstOrFail();
            if ($lockedPayment->status === 'succeeded') {
                return false;
            }

            $lockedPayment->update([
                'status' => 'succeeded',
                'provider_reference' => $transactionId,
                'failure_reason' => null,
            ]);

            $order = Order::whereKey($lockedPayment->order_id)->lockForUpdate()->first();
            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'processing']);
            }

            if ($lockedPayment->cart_session_id) {
                Cart::where('session_id', $lockedPayment->cart_session_id)->delete();
            }

            return true;
        });

        if ($newlyFunded) {
            DB::afterCommit(function () use ($payment) {
                $order = Order::find($payment->order_id);
                if (!$order) {
                    return;
                }

                try {
                    $adminEmail = SettingsHelper::getAdminEmail();
                    Mail::send('emails.admin-order-notification', ['order' => $order], function ($message) use ($adminEmail, $order) {
                        $message->to($adminEmail)->subject('New Order Received - ' . $order->order_number);
                    });
                } catch (\Throwable) {
                    Log::warning('Failed to send admin order notification.', ['order_id' => $order->id]);
                }

                try {
                    Mail::to($order->customer_email)->send(new OrderPlacedCustomer($order));
                } catch (\Throwable) {
                    Log::warning('Failed to send customer order notification.', ['order_id' => $order->id]);
                }
            });
        }

        return $newlyFunded;
    }
}
