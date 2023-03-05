<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create(
            [
                'name' => 'Test User',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN
            ]
        );
        User::factory(100)->create();
        Product::factory(1000)->create();
        Order::factory(1000)->create();
        OrderProduct::factory(5000)->create();
    }
}
