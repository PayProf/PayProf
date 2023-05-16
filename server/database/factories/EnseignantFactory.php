<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'PPR' =>fake()->numberBetween(),
            'nom' =>fake()->lastName(),
            'prenom' =>fake()->firstName(),
            'date_naissance' =>fake()->date(),
            'etablissement_id'=>fake()->numberBetween(1,10),
            'grade_id'=>fake()->numberBetween(1,10),
            'user_id'=>fake()->numberBetween(1,10),
            'email_perso'=>fake()->email(),
        ];
    }
}
