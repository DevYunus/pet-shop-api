<?php

namespace Database\Seeders;

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
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            OrderStatusSeeder::class,
            PaymentSeeder::class,
            OrderSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
