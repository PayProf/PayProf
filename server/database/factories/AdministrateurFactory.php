<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrateur>
 */
class AdministrateurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
                'PPR'=>fake()->numberBetween(),
                'nom'=>fake()->lastName(),
                'prenom'=>fake()->firstName(),
                'etablissement_id'=>fake()->numberBetween(1,10),
        ];
    }
}
