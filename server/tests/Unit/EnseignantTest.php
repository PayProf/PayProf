<?php

namespace Tests\Unit;

use App\Models\Enseignant;
use Tests\TestCase;
use App\Http\Controllers\api\EnseignantController;
use App\Models\Administrateur;
use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\Intervention;
use App\Models\Paiements;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotSame;
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
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Send a GET request to the 'api/Enseignant' endpoint
        $response = $mock_user->get('api/Enseignant');

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
        $user = User::factory()->create([
            'role' => 2,
        ]);
        $admin_etab = Administrateur::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::first()->id
        ]);

        // Create a new instance of the Enseignant model using the factory
        $ens = Enseignant::factory()->make();

        // Send a JSON POST request to the 'api/Enseignant' endpoint with the specified data
        $response = $this->actingAs($user)->json('POST', 'api/Enseignant', [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom,
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => Grade::first()->designation,
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
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Enseignant model using the factory and save it to the database
        $ens = Enseignant::factory()->create();

        // Send a GET request to the 'api/Enseignant/{id}' endpoint, where {id} is the ID of the created Enseignant
        $response = $mock_user->get('api/Enseignant/' . $ens->id);

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
        $user = User::factory()->create([
            'role' => 2
        ]);
        $admin_etab = Administrateur::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::first()->id
        ]);

        // Create a new instance of the Enseignant model using the factory
        $ens = Enseignant::factory()->create([
            "etablissement_id" =>  $admin_etab->etablissement_id
        ]);

        // Retrieve the ID of the created Enseignant record
        $ens_id = Enseignant::where("PPR", $ens->PPR)->first()->id;

        // Send a JSON PUT request to the 'api/Enseignant/{id}' endpoint to update the Enseignant record
        $resp = $this->actingAs($user)->json('PATCH', 'api/Enseignant/' . $ens_id, [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom . "|",
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => Grade::first()->designation,
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

        $user = User::factory()->create([
            'role' => 2
        ]);
        $admin_etab = Administrateur::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::first()->id
        ]);
        // Create a new instance of the Enseignant model and save it to the database
        $ens = Enseignant::factory()->create([
            'etablissement_id' => $admin_etab->etablissement_id
        ]);
        // Call the destroy method on the EnseignantController instance to delete the Enseignant record
        $res = $this->actingAs($user)->json("delete", 'api/Enseignant/' . $ens->id);

        // Assert that the status code of the response is 200 (OK)
        assertSame($res->status(), 200, "Enseignant not deleted !!!");
    }

    /**
     * A basic unit for EnseignantController::ShowMyInterventions()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_intervention_is_functional()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        // Generate a random user ID between 1 and Enseignant::count()
        $res = $this->actingAs($user)->json('GET', "api/Enseignant/ens/MyIntervention");

        // Assert that the status code of the response is 200 (OK)
        assertNotSame($res->status(), 403, "interventions method is not fully functional");
    }

    public function test_show_my_intervention_is_returning_the_correct_data()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        $ens = Enseignant::factory()->create([
            'user_id' => $user->id
        ]);
        $inter = Intervention::factory()->create([
            'enseignant_id' => $user->enseignant->id,
        ]);
        // Generate a random user ID between 1 and Enseignant::count()
        $res = $this->actingAs($user)->json('GET', "api/Enseignant/ens/MyIntervention");
        // Assert that the status code of the response is 200 (OK)
        assertNotNull($res->getData(), "interventions method is not fully functional");
    }
    public function test_show_my_graph_is_up_and_running()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        $ens = Enseignant::factory()->create([
            'user_id' => $user->id
        ]);
        // Generate a random user ID between 1 and Enseignant::count()
        $res = $this->actingAs($user)->json('GET', "api/Enseignant/ens/MyGraphe");
        // Assert that the status code of the response is 200 (OK)
        assertNotNull($res->getData(), "interventions method is not fully functional");
    }
    /**
     * A basic unit for EnseignantController::ShowMyPayments()
     * test if the method works properly
     * @return void
     */
    public function test_show_payments_is_working_correctly()
    {
        $ens_id = Enseignant::with('paiements')->first()->user_id;
        $user = User::where('id', $ens_id)->first();

        // Generate a random user ID between 1 and Enseignant::count()
        $res = $this->actingAs($user)->json('GET', "api/Enseignant/ens/MyPayments");
        assertSame($res->status(), 200, "payments method is not fully functional");
    }
    public function test_show_payments_is_returning_the_correct_data()
    {
        $ens_id = Enseignant::with('paiements')->first();
        $user = User::where('id', $ens_id->user_id)->first();
        $paiement = Paiements::factory()->create([
            'enseignant_id' => $ens_id->id
        ]);

        // Generate a random user ID between 1 and Enseignant::count()
        $res = $this->actingAs($user)->json('GET', "api/Enseignant/ens/MyPayments");
        assertNotNull($res->getData(), "payments method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::UploadImage()
     * test if the method works properly
     * @return void
     */
    public function test_upload_image_is_working_correctly()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        $ens = Enseignant::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::count()
        ]);
        // Set up a fake local storage for testing
        Storage::fake('local');

        // Create a fake uploaded file named 'test.png'
        $file = UploadedFile::fake()->create('test.png');

        // Send a JSON POST request to the 'api/Enseignant/6/UploadMyImage' endpoint with the file
        $response = $this->actingAs($user)->json(
            'post',
            'api/Enseignant/ens/UploadMyImage',
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
        $user = User::factory()->create([
            'role' => 0
        ]);
        // Call the ShowMyProfil method on the EnseignantController instance with the user ID from the dump_user record
        $response = $this->actingAs($user)->json('get', "Enseignant/ens/ShowMyProfil");

        // Assert that the PPR (Personal Public Registry) of the response matches the PPR of the dump_user record
        assertNotSame($response->status(), 403, "show profile method is not fully functional");
    }
    public function test_show_my_profile_is_returning_the_correct_data()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        // Call the ShowMyProfil method on the EnseignantController instance with the user ID from the dump_user record
        $response = $this->actingAs($user)->json('get', "Enseignant/ens/ShowMyProfil");

        // Assert that the PPR (Personal Public Registry) of the response matches the PPR of the dump_user record
        assertNotNull($response->getData(), "show profile method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::MyHours()
     * test if the method works properly
     * @return void
     */
    public function test_show_my_hours_is_working()
    {
        $user = User::where('role', 0)->first();
        $ens = Enseignant::factory()->create([
            "user_id" => $user->id,
            "etablissement_id" =>  Etablissement::count()
        ]);

        // Call the MyHours method on the EnseignantController instance with the user ID from the dump_user record
        $response = $this->actingAs($user)->json('get', "api/Enseignant/ens/MyHours");
        // Assert that the status code of the response is 200 (OK)
        assertNotSame($response->status(), 403, "my hours method is not fully functional");
    }

    /**
     * A basic unit for EnseignantController::UpdateMyEmail()
     * test if the method works properly
     * @return void
     */
    public function test_update_email_is_working_correctly()
    {
        $user = User::factory()->create([
            'role' => 0
        ]);
        $ens = Enseignant::factory()->create([
            "user_id" => $user->id,
        ]);

        // Create a new instance of the Administrateur model using the factory and save it to the database

        // Generate a new email by appending 'test' to the existing email
        $new_email = 'test' . $ens->email_perso;

        // Send a PUT request to update the email of the Administrateur
        $response = $this->actingAs($user)->json('PATCH', 'api/Enseignant/ens/UpdateMyEmail', [
            'email_perso' => $new_email
        ]);
        // Retrieve the updated email from the database
        $ens_updated_email = Enseignant::where('user_id', $user->id)->orderBy('PPR', 'DESC')->first()->email_perso;
        // Assert that the email in the database matches the updated email
        assertSame($response->status(), 200, 'update email has a problem');
        assertEquals($new_email, $ens_updated_email, 'Email not updated correctly');
    }
}
