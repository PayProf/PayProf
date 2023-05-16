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
<<<<<<< HEAD
           'code'=>fake()->countryCode(),
            'nom' =>fake()->name(),
            'telephone' =>fake()->phoneNumber(),
            'Faxe' =>fake()->numberBetween(),
            'ville' => fake()->city(),
            'Nbrenseignants'=> fake()->numberBetween(20,100),
=======
            'code' => fake()->countryCode(),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'Faxe' => fake()->numberBetween(),
            'city' => fake()->city(),
            'numberTeacher' => fake()->numberBetween(20, 100),
>>>>>>> 7c534197aef78ef9d2a1e01a4270bafd417f7d6c
        ];
    }
}