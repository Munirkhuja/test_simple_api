<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product = Product::query()->inRandomOrder()->first();
        $product_count = rand(1, 10);
        return [
            'order_id' => Order::query()->inRandomOrder()->value('id'),
            'product_id' => $product->id,
            'product_count' => $product_count,
            'amount' => $product->price * $this->count,
        ];
    }
}
