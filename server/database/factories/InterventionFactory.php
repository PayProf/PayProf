<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'intitule_intervention' => fake()->realText(30, 2),
            'enseignant_id' => fake()->numberBetween(1, 10),
            'etablissement_id' => fake()->numberBetween(1, 10),

            'date_debut' => fake()->date(),
            'date_fin' => fake()->date(),
            'visa_uae' => fake()->numberBetween(0, 1),
            'visa_etab' => fake()->numberBetween(0, 1),
            'Nbr_heures' => fake()->numberBetween(),
        ];
    }
}