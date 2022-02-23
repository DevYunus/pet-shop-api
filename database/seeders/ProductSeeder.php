<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Product::factory()->count(5)->create();

        Product::factory()->count(5)
            ->state(new Sequence(
                ['title' => 'Product 1'],
                ['title' => 'Product 2'],
                ['title' => 'Product 3'],
                ['title' => 'Product 4'],
                ['title' => 'Product 5'],

            ))
            ->create();
    }
}
