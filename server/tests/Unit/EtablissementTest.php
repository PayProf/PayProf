<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\EtablissementController;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\User;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertNull;



class EtablissementTest extends TestCase
{

    /**
     * A basic unit for EtablissementController::index()
     * test if the method works properly
     * @return void
     */
    public function test_index_method_is_functional()
    {
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);
        // Send a GET request to the 'api/Enseignant' endpoint
        $response = $this->actingAs($user)->get('api/etablissements');

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * A basic unit for EtablissementController::store()
     * test if the method works properly
     * @return void
     */
    public function test_store_is_working()
    {
        $user = User::factory()->create([
            'role' => 4
        ]);
        // Create a new instance of the Etablissement model using the factory
        $etab = Etablissement::factory()->make();

        // Prepare the data for the request payload
        $data = [
            'nom' => $etab->nom,
            'code' => $etab->code,
            'telephone' => $etab->telephone,
            'FAX' => $etab->FAX,
            'ville' => $etab->ville
        ];

        // Send a JSON POST request to the 'api/etablissements' endpoint with the data payload
        $request = $this->actingAs($user)->json('post', 'api/etablissements', $data);

        // Assert that the status code of the response is 200 (OK)
        assertSame($request->status(), 200, 'store is not working');
    }


    /**
     * A basic unit for EtablissementController::show()
     * test if the method works properly
     * @return void
     */
    public function test_show_specific_etablissement_is_up_and_running()
    {
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);
        // Generate a random etablissement ID between 2 and  $random_etab_id
        $random_etab_id = Etablissement::first()->id;
        // Send a JSON GET request to the 'api/etablissements/8?with=Enseignants' endpoint
        $response = $this->actingAs($user)->json('GET', 'api/etablissements/' . $random_etab_id . '?with=Enseignants');

        // Assert that the status code of the response is 200 (OK)
        assertSame($response->status(), 200, 'show specific etablissement is not working');
    }

    /**
     * A basic unit for EtablissementController::update()
     * test if the method works properly
     * @return void
     */
    public function test_update_etablissement_is_running()
    {
        $user = User::factory()->create([
            'role' => 4
        ]);
        // Generate a random etablissement ID between 2 and  $random_etab_id
        $random_etab_id =  Etablissement::first()->id;
        // Find an Etablissement record with ID  $random_etab_id
        $etab = Etablissement::find($random_etab_id);

        // Prepare the data for the update request payload
        $data = [
            'nom' => $etab->nom . 'test',
            'code' => $etab->code,
            'telephone' => $etab->telephone,
            'FAX' => $etab->FAX,
            'ville' => $etab->ville
        ];

        // Send a JSON PATCH request to the 'api/etablissements/{id}' endpoint with the data payload
        $response = $this->actingAs($user)->json('PATCH', 'api/etablissements/' . $etab->id, $data);

        // Retrieve the updated Etablissement record by ID
        $updatedEtab = Etablissement::find($etab->id);

        // Assert that the updated Etablissement's name matches the updated value
        assertSame($updatedEtab->nom, $data["nom"], 'update etablissement is not working');
    }

    /**
     * A basic unit for EtablissementController::destroy()
     * test if the method works properly
     * @return void
     */
    public function test_destroy_method_works_correctly()
    {
        $user = User::factory()->create([
            'role' => 4
        ]);
        // create a fake Etablissement record
        $etab = Etablissement::factory()->create();

        // Create an instance of the EtablissementController
        $controller = new EtablissementController();

        // Call the destroy method on the EtablissementController with the ID of the Etablissement record
        $response = $this->actingAs($user)->json("delete", 'api/etablissements/' . $etab->id);

        // Assert that the Etablissement record with the same code as the deleted record does not exist
        assertNull(Etablissement::where("code", $etab->code)->first());
    }

    /**
     * A basic unit for EtablissementController::ShowMyetablissement()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_etablissements()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        $ens = Enseignant::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::count()
        ]);

        $response = $this->actingAs($user)->json("get", 'api/etablissements/' . $user->id . '/myetablissement');
        assertSame($response->status(), 200, 'show specific etablissement is not working');
    }
}
