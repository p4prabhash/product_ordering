<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;


    class OrderTest extends TestCase
    {
        use RefreshDatabase;
    
        public function setUp(): void
        {
            parent::setUp();
            $this->seed('ProductSeeder');
        }
    
        public function test_order_submission()
        {
            $products = Product::all()->pluck('id')->toArray();
    
            $response = $this->post('/order', [
                'email' => 'test@example.com',
                'shipping_address' => '123 Test Street',
                'products' => $products,
            ]);
    
            $response->assertStatus(200);
            $this->assertDatabaseHas('orders', ['user_email' => 'test@example.com']);
            $this->assertDatabaseHas('order_product', ['product_id' => $products[0]]);
        }
    
        public function test_order_submission_from_somalia_is_blocked()
        {
            $products = Product::all()->pluck('id')->toArray();
    
            $response = $this->post('/order', [
                'email' => 'test@example.com',
                'shipping_address' => '123 Test Street',
                'products' => $products,
                'REMOTE_ADDR' => '197.157.252.1', // Somalia IP address
            ]);
    
            $response->assertStatus(403);
        }
    }
