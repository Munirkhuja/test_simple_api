<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_date' => $this->faker->date(),
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'phone' => $this->faker->phoneNumber(),
            'lng' => $this->faker->randomFloat('16', 44, 66),
            'lat' => $this->faker->randomFloat('16', 44, 66),
        ];
    }
}
