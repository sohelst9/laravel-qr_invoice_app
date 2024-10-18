<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'unique_id' => strtoupper($this->faker->lexify('????-????-????')),
            'phone' => $this->faker->phoneNumber(),
            'biodata' => $this->faker->paragraph(),
            'status' => 'unchecked',
            'password' => bcrypt('password'),
        ];
    }
}
