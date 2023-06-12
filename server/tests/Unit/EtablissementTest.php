<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\EtablissementController;
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
        // Create a new instance of the EtablissementController
        $controller = new EtablissementController();

        // Call the index method on the EtablissementController instance
        $response = $controller->index();

        // Assert that the status code of the response is 200 (OK)
        assertSame($response->status(), 200, 'index is not working');
    }

    /**
     * A basic unit for EtablissementController::store()
     * test if the method works properly
     * @return void
     */
    public function test_store_is_working()
    {
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
        $request = $this->json('post', 'api/etablissements', $data);

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
        // Generate a random etablissement ID between 2 and  $random_etab_id
        $random_etab_id = rand(1, Etablissement::count());
        // Send a JSON GET request to the 'api/etablissements/8?with=Enseignants' endpoint
        $response = $this->json('GET', 'api/etablissements/' . $random_etab_id . '?with=Enseignants');

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
        // Generate a random etablissement ID between 2 and  $random_etab_id
        $random_etab_id = rand(1, Etablissement::count());
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
        $response = $this->json('PATCH', 'api/etablissements/' . $etab->id, $data);

        // Retrieve the updated Etablissement record by ID
        $updatedEtab = Etablissement::find(9);

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
        // create a fake Etablissement record
        $etab = Etablissement::factory()->create();

        // Create an instance of the EtablissementController
        $controller = new EtablissementController();

        // Call the destroy method on the EtablissementController with the ID of the Etablissement record
        $response = $controller->destroy($etab->id);

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
        // Generate a random etablissement ID between 1 and  $random_etab_id
        $random_etab_id = rand(1, Etablissement::count());
        // Find a user with ID $random_etab_id
        $user = User::find($random_etab_id);

        // Create an instance of the EtablissementController
        $controller = new EtablissementController();

        // Call the Show_Myetablissement method on the EtablissementController with the user ID and role
        $response = $controller->Show_Myetablissement($user->id, $user->role);
    }
}
