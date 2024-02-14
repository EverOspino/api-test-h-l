<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class; 

    public function definition(): array
    {
        return [
            'cedula' => $this->faker->unique()->numberBetween(100000000, 1100000000),
            'nombre_completo' => $this->faker->name()
        ];
    }
}
