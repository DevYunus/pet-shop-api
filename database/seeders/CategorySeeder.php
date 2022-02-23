<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
//        Category::factory()->count(5)->create();
        Category::factory()->count(5)
            ->state(new Sequence(
                ['title' => 'Category 1'],
                ['title' => 'Category 2'],
                ['title' => 'Category 3'],
                ['title' => 'Category 4'],
                ['title' => 'Category 5'],

            ))
            ->create();
    }

}
