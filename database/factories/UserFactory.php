<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'is_admin' => $this->faker->boolean,
            'email' => $this->faker->safeEmail,
            'email_verified_at' => $this->faker->dateTime(),
            'password' => $this->faker->password,
            'avatar' => $this->faker->uuid,
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'phone_number' => $this->faker->phoneNumber,
            'is_marketing' => $this->faker->boolean,
            'last_login_at' => $this->faker->dateTime(),
        ];
    }
}
