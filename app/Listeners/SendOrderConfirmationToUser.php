<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\OrderSubmitted;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationToUser
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
    
        // Check if $products is not null before using pluck()
        if ($products) {
            $productNames = $products->pluck('name')->toArray();
        } else {
            $productNames = []; 
        }
    
        Mail::raw("Thank you for your order! You ordered: " . implode(', ', $productNames), function ($message) use ($order) {
            $message->to($order->user_email)
                    ->subject('Order Confirmation');
        });
    }
    
}
