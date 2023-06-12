<?php

namespace Tests\Unit;

use App\Models\Enseignant;
use Tests\TestCase;
use App\Http\Controllers\api\EnseignantController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertSame;

class EnseignantTest extends TestCase
{
    /**
     * A basic unit for EnseignantController::index()
     * test if the method works properly
     * @return void
     */
    public function test_index_enseignant_works_correctly()
    {
        // Send a GET request to the 'api/Enseignant' endpoint
        $response = $this->get('api/Enseignant');

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * A basic unit for EnseignantController::store()
     * test if the method works properly
     * @return void
     */
    public function test_store_method_works_correctly()
    {
        // Create a new instance of the Enseignant model using the factory
        $ens = Enseignant::factory()->make();
        // Send a JSON POST request to the 'api/Enseignant' endpoint with the specified data
        $response = $this->json('POST', 'api/Enseignant', [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom,
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
            'email_perso' => $ens->email_perso
        ]);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * A basic unit for EnseignantController::show()
     * test if the method works properly
     * @return void
     */
    public function test_show_enseignant_works_correctly()
    {
        // Create a new instance of the Enseignant model using the factory and save it to the database
        $ens = Enseignant::factory()->create();

        // Send a GET request to the 'api/Enseignant/{id}' endpoint, where {id} is the ID of the created Enseignant
        $response = $this->get('api/Enseignant/' . $ens->id);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * A basic unit for EnseignantController::update()
     * test if the method works properly
     * @return void
     */
    public function test_update_method_works_correctly()
    {
        // Create a new instance of the Enseignant model using the factory
        $ens = Enseignant::factory()->make();

        // Send a JSON POST request to the 'api/Enseignant' endpoint with the specified data to create a new Enseignant record
        $response = $this->json('POST', 'api/Enseignant', [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom,
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
            'email_perso' => $ens->email_perso
        ]);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);

        // Retrieve the ID of the created Enseignant record
        $ens_id = Enseignant::where("PPR", $ens->PPR)->first()->id;

        // Send a JSON PUT request to the 'api/Enseignant/{id}' endpoint to update the Enseignant record
        $resp = $this->json('PUT', 'api/Enseignant/' . $ens_id, [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom . "|",
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
        ]);

        // Assert that the response status code is 200 (OK)
        $resp->assertStatus(200);
    }
    /**
     * A basic unit for EnseignantController::destroy()
     * test if the method works properly
     * @return void
     */
    public function test_destroy_works_properly()
    {
        // Create a new instance of the Enseignant model and save it to the database
        $ens = Enseignant::factory()->create();

        // Create a new instance of the EnseignantController
        $response = new EnseignantController();

        // Call the destroy method on the EnseignantController instance to delete the Enseignant record
        $res = $response->destroy($ens->id)->status();

        // Assert that the status code of the response is 200 (OK)
        assertSame($res, 200, "Enseignant not deleted !!!");
    }

    /**
     * A basic unit for EnseignantController::ShowMyInterventions()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_intervention_is_functional()
    {
        // Generate a random user ID between 1 and Enseignant::count()
        $random_user_id = rand(1, Enseignant::count());

        // Create a new instance of the EnseignantController
        $response = new EnseignantController();

        // Call the ShowMyInterventions method on the EnseignantController instance with the random user ID
        $res = $response->ShowMyInterventions($random_user_id)->status();

        // Assert that the status code of the response is 200 (OK)
        assertSame($res, 200, "interventions method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::ShowMyPayments()
     * test if the method works properly
     * @return void
     */
    public function test_show_payments_is_working_correctly()
    {
        // Generate a random user ID between 2 and 26
        $random_user_id = rand(2, 26);

        // Create a new instance of the EnseignantController
        $response = new EnseignantController();

        // Call the ShowMyPayments method on the EnseignantController instance with the random user ID
        $res = $response->ShowMyPayments($random_user_id);

        // Get the data returned from the response
        $data_returned = $res->getData()->data->paiements;

        // Check if the returned data is empty
        if (empty($data_returned)) {
            // Assert that the status code of the response is 404 (Not Found)
            assertSame($res->status(), 404, "payments method is not fully functional");
        } else {
            // Assert that the status code of the response is 200 (OK)
            assertSame($res->status(), 200, "payments method is not fully functional");
        }
    }

    /**
     * A basic unit for EnseignantController::UploadImage()
     * test if the method works properly
     * @return void
     */
    public function test_upload_image_is_working_correctly()
    {
        // Set up a fake local storage for testing
        Storage::fake('local');

        // Create a fake uploaded file named 'test.png'
        $file = UploadedFile::fake()->create('test.png');

        // Send a JSON POST request to the 'api/Enseignant/6/UploadMyImage' endpoint with the file
        $response = $this->json(
            'post',
            'api/Enseignant/6/UploadMyImage',
            [
                'image' => $file
            ]
        );

        // Generate a unique filename based on the current time
        $filename = time() . '_' . 'test.png';

        // Specify the path where the file should be stored
        $file = public_path('uploads') . '/' . $filename;

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'the response is not 200 ');

        // Assert that the image file exists at the specified path
        assertFileExists($file, "the image file is not stored ");
    }

    /**
     * A basic unit for EnseignantController::ShowMyProfil()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_profile_is_functional()
    {
        // Get the first Enseignant record from the database
        $dump_user = Enseignant::first();

        // Create a new instance of the EnseignantController
        $response = new EnseignantController();

        // Call the ShowMyProfil method on the EnseignantController instance with the user ID from the dump_user record
        $res = $response->ShowMyProfil($dump_user->user_id);

        // Assert that the PPR (Personal Public Registry) of the response matches the PPR of the dump_user record
        assertSame($res->PPR, $dump_user->PPR, "show profile method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::MyHours()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_hours_is_working()
    {
        // Get the first Enseignant record from the database
        $dump_user = Enseignant::first();

        // Create a new instance of the EnseignantController
        $response = new EnseignantController();

        // Call the MyHours method on the EnseignantController instance with the user ID from the dump_user record
        $res = $response->MyHours($dump_user->user_id);

        // Assert that the status code of the response is 200 (OK)
        assertSame($res->status(), 200, "interventions method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::UpdateMyEmail()
     * test if the method works properly
     * @return void
     */
    public function test_update_email_is_working_correctly()
    {
        // Get the first Enseignant record from the database
        $dump_user = Enseignant::first();

        // Generate a new email by appending 'aga' to the existing email
        $nv_email = $dump_user->email_perso . 'test';

        // Send a JSON PATCH request to the 'api/Enseignant/{user_id}/UpdateMyEmail' endpoint
        // with the updated email as the request payload
        $resp = $this->json('PATCH', 'api/Enseignant/' . $dump_user->user_id . '/UpdateMyEmail', [
            'email_perso' => $nv_email
        ]);

        // Assert that the email of the first Enseignant record in the database matches the updated email
        assertEquals($nv_email, Enseignant::first()->email_perso, 'email not updated correctly');
    }
}
