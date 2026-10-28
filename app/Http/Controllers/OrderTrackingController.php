<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function create(Request $request)
    {
        return view('orders.track', [
            'orderNumber' => strtoupper(trim((string) $request->query('order_number', ''))),
            'order' => null,
            'lookupAttempted' => false,
        ]);
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:32', 'regex:/^ORD-[A-Z0-9]{8}$/i'],
        ], [
            'order_number.regex' => 'Enter the order number in the format ORD-XXXXXXXX.',
        ]);

        $orderNumber = strtoupper(trim($validated['order_number']));
        $order = Order::query()
            ->select(['id', 'order_number', 'status', 'payment_method', 'created_at'])
            ->where('order_number', $orderNumber)
            ->first();

        return view('orders.track', [
            'orderNumber' => $orderNumber,
            'order' => $order,
            'lookupAttempted' => true,
        ]);
    }
}
