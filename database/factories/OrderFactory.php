<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::first(),
            'order_status_id' => OrderStatus::first(),
            'payment_id' => Payment::first(),
            'uuid' => $this->faker->uuid,
            'address' => json_encode([]),
            'delivery_fee' => $this->faker->randomFloat(0, 0, 33),
            'amount' => $this->faker->randomFloat(0, 0, 99),
            'shipped_at' => $this->faker->dateTime(),
        ];
    }
}
