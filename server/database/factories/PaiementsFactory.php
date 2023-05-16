<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paiements>
 */
class PaiementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'enseignant_id' => fake()->numberBetween(1, 10),
            'etablissement_id' => fake()->numberBetween(1, 10),
            'VH' => fake()->numberBetween(300, 1000),
            'Taux_H' => fake()->numberBetween(20, 200),
            'Brut' => fake()->numberBetween(4500, 10000),
            'IR' => fake()->numberBetween(280, 450),
            'Net' => fake()->numberBetween(4500, 10000),


        ];
    }
}