<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administrateur;
use App\Models\Directeur;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\Intervention;
use App\Models\Paiements;
use App\Models\TypeUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Etablissement::factory(10)->create();
        User::factory(10)->create();
        Grade::factory(10)->create();
        Enseignant::factory(10)->create();
        Administrateur::factory(10)->create();
        Intervention::factory(10)->create();
       
        Paiements::factory(10)->create();
        Directeur:: factory(10)->create();
       
    }
}
