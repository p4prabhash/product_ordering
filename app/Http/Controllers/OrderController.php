<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Events\OrderSubmitted;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'shipping_address' => 'required',
            'products' => 'required|array',
            'products.*' => 'required|integer|exists:products,id',
        ]);

        // Check IP location
        $ip = $request->ip();
        $response = Http::get('https://freegeoip.app/json/'.$ip);
        if ($response->successful() && $response->json()['country_name'] === 'Somalia') {
            return response()->json(['error' => 'Orders from Somalia are not allowed.'], 403);
        }

        $order = Order::create([
            'user_email' => $request->email,
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($request->products as $productId) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => 1, 
            ]);
        }

        event(new OrderSubmitted($order));

        return response()->json(['message' => 'Order placed successfully.']);
    }
}
