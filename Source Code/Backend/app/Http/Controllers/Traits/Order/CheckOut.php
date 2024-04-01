<?php

namespace App\Http\Controllers\Traits\Order;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

trait Checkout
{
    public function checkoutSuccess(Order $id, Request $request)
    {
        $id->update([
            'is_temp' => false,
            'token'   => $request->token,
        ]);

        // create payment
        $status = Payment::getStatusFor('status');

        $id->payment()->create([
            'user_id'   => $id->customer_id,
            'status_id' => $id->paymentMethod->type == 'offline'
                            ? $status->firstWhere('order', 1)->id
                            : $status->firstWhere('order', 2)->id,
        ]);

        // return to user
        $msg = 'thank you';

        if ($request->expectsJson()) {
            return response()->json(['message' => $msg]);
        }

        flash()->success($msg);

        return redirect()->route('order.show', $id->id);
    }
}
