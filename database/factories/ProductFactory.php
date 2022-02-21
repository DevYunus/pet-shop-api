<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'category_uuid' => $this->faker->uuid,
            'uuid' => $this->faker->uuid,
            'title' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(0, 0, 9999.),
            'description' => $this->faker->text,
            'metadata' => '{}',
        ];
    }
}
