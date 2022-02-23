<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Order::factory()->count(5)->create();

        foreach (Order::all() as $order){
            $faker= Faker::create();
            $product= Product::inRandomOrder()->take(rand(1,3))->pluck('id');
            $order->products()->attach($product,
            ['quantity' => $faker->randomNumber(1, 10)]
            );
        }
    }
}
