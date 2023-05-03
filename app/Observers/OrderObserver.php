<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function updated(Order $order)
    {

        $originalOrder = new Order(
            collect($order->getOriginal())
            ->only($order->statusses)
            ->toArray()
        );

        $filledStatus = collect($order->getDirty())
            ->only($order->statusses)
            ->filter(fn ($status) => filled($status));

        if($originalOrder->status() != $order->status() && $filledStatus->count())
        {
            dd('send email');
        }
    }
}
