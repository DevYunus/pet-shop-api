<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;


class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        OrderStatus::factory()->count(4)
            ->state(new Sequence(
                ['title' => 'Ordered'],
                ['title' => 'InProcess'],
                ['title' => 'Dispatched'],
                ['title' => 'Delivered'],
            ))
            ->create();
    }
}
