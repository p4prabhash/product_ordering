<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\OrderSubmitted;


class SendOrderNotificationToWarehouse
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSubmitted $event)
    {
        $order = $event->order;
        $products = $order->products;
    
        if ($products && $products->isNotEmpty()) {
            $productNames = $products->pluck('name')->toArray();
            $productsList = implode(', ', $productNames);
        } else {
            $productsList = 'No products';
        }
    
        Mail::raw("New order received from {$order->user_email} with shipping address {$order->shipping_address}. Products: " . $productsList, function ($message) {
            $message->to('warehouse@example.org')
                    ->subject('New Order Received');
        });
    }
    
}
