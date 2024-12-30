<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function created(Order $order)
    {
        // Example: Send an alert when a new order is created
        logger("New Order Created with ID: {$order->id}");
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        // Example: Log order update
        logger("Order updated with ID: {$order->id}");
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        // Example: Send notification when an order is deleted
        logger("Order deleted with ID: {$order->id}");
    }
}