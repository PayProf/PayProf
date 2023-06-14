<?php

namespace Tests\Unit;

use App\Models\Administrateur;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\Intervention;
use App\Models\User;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

class InterventionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_method_works_correctly()
    {
        // Create a user with role 4
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // Create an instance of the InterventionController
        $response = $this->actingAs($user)->get('api/Intervention');

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'user method does not have correct permissions');
    }
    public function test_index_method_is_not_functional_with_wrong_roles()
    {
        // Create a user with role 4
        $user = User::factory()->create([
            'role' => 1
        ]);

        // Create an instance of the InterventionController
        $response = $this->actingAs($user)->get('api/Intervention');

        // Assert that the response status code is 403 (Forbidden)
        assertSame($response->status(), 403, 'User does not have correct permissions (role = ' . $user->role . ')');
    }
    public function test_store_is_working_with_correct_role()
    {
        // Create a user with role 4
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $admin = Administrateur::factory()->create([
            'user_id' => $admin_etab->id
        ]);
        $ens = Enseignant::factory()->create();
        // Create a new instance of Intervention using the factory
        $inter = Intervention::factory()->make();

        // Send a JSON POST request to store the admin
        $response = $this->actingAs($admin_etab)->json('POST', 'api/Intervention', [
            'IntituleIntervention' => $inter->intitule_intervention,
            'AnneeUniv' => 2023,
            'Semestre' => 'S1',
            'DateDebut' => $inter->date_debut,
            'NbrHeures' => $inter->Nbr_heures,
            'DateFin' => $inter->date_fin,
            'PPR' => $ens->PPR,

        ]);

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'The admin is not stored');
    }

    public function test_show_intervention_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->get('api/Intervention/' . $inter->id);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }
    public function test_show_works_correctly_only_with_correct_roles()
    {
        $admin_etab = User::factory()->create([
            'role' => 1
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->get('api/Intervention/' . $inter->id);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(403);
    }

    public function test_update_method_works_correctly()
    {

        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm = Administrateur::factory()->create([
            'user_id' => $admin_etab->id
        ]);

        $ens = Enseignant::factory()->create([
            'etablissement_id' => $adm->etablissement_id
        ]);
        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create([
            'enseignant_id' => $ens->id,
            'etablissement_id' => $adm->etablissement_id
        ]);
        $admin_etab->role = 2;
        $admin_etab->save();
        // Send a PATCH request to update the Directeur record
        $resp = $this->actingAs($admin_etab)->json(
            'PUT',
            'api/Intervention/' . $inter->id,
            [
                'IntituleIntervention' => $inter->intitule_intervention,
                'AnneeUniv' => 2023,
                'Semestre' => 'S2',
                'DateDebut' => $inter->date_debut,
                'NbrHeures' => $inter->Nbr_heures,
                'DateFin' => $inter->date_fin,
                'PPR' => $ens->PPR,
            ]
        );
        // Assert that the response status code is 200 (OK)
        $resp->assertStatus(200);
    }

    public function test_destroy_works_properly()
    {
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm = Administrateur::factory()->create([
            'user_id' => $admin_etab->id,
            'etablissement_id' => Etablissement::first()
        ]);
        $ens = Enseignant::factory()->create([
            'etablissement_id' => $adm->etablissement_id
        ]);
        // Create a new instance of the Intervention model using the factory and save it to the database
        $inter = Intervention::factory()->create([
            'enseignant_id' => $ens->id,
            'etablissement_id' => $adm->etablissement_id
        ]);

        // Send a DELETE request to delete the Intervention record
        $response = $this->actingAs($admin_etab)->json('DELETE', 'api/Intervention/' . $inter->id);
        // Assert that the Intervention record is not found in the database
        // Assert that the status code of the response is 200 (OK)
        assertSame($response->status(), 200, "Intervention not deleted!!!");
    }

    public function test_show_more_works_correctly_only_with_correct_roles()
    {
        $admin_etab = User::factory()->create([
            'role' => rand(3, 4)
        ]);
        $adm = Administrateur::factory()->create([
            'user_id' => $admin_etab->id
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->get('api/Intervention/' . $inter->id . '/showmore');
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    public function test_active_visa_uae_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 3
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->json('patch', 'api/Intervention/' . $inter->id . '/visauae', [
            'VisaUae' => 1
        ]);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }
    public function test_active_visa_etab_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 1
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->json('patch', 'api/Intervention/' . $inter->id . '/visaetab', [
            'VisaEtab' => 1
        ]);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    public function test_ShowMyEtabInterventions_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm = Administrateur::factory()->create([
            'user_id' => $admin_etab->id
        ]);

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->json('get', 'api/Intervention/int/ShowMyEtabInterventions');
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    public function test_EnseignantInterventions_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm = Administrateur::factory()->create([
            'user_id' => $admin_etab->id
        ]);

        $inter = Intervention::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->json('get', 'api/Intervention/2/EnseignantInterventions');
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }
}
