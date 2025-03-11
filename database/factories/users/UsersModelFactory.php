<?php

namespace Database\Factories\users;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\users\UsersModel>
 */
class UsersModelFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->numerify('(##) 9 ####-####'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('12345678'),
            'status' => 1,
        ];
    }

    // Permite criar um usuário com e-mail fixo
    public function withFixedEmail(string $email): self
    {
        return $this->state([
            'email' => $email,
            'password' => Hash::make('12345678'),
        ]);
    }
}
