<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
//        Payment::factory()->count(5)->create();
        Payment::factory()->count(3)
            ->state(new Sequence(
                ['type' => 'credit_card'],
                ['type' => 'cash_on_delivery'],
                ['type' => 'bank_transfer'],
            ))
            ->create();

    }
}
