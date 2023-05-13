<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etablissement>
 */
class EtablissementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => fake()->countryCode(),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'Faxe' => fake()->numberBetween(),
            'city' => fake()->city(),
            'numberTeacher' => fake()->numberBetween(20, 100),
        ];
    }
}