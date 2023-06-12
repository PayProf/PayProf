<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\AuthController;
use App\Models\Administrateur;
use App\Models\User;
use PHPUnit\Framework;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertThat;



class AdministrateurTest extends TestCase
{
    public function test_index_method_is_functional()
    {
        // Create a user with role 4
        $user = User::factory()->create([
            'role' => 4
        ]);

        // we create a mocking  user
        $mock_user  = $this->actingAs($user);

        // Create an instance of the AdministrateurController
        $controller = new AdministrateurController($mock_user);

        // Call the index method
        $response = $controller->index();

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'user method does not have correct permissions');
    }

    public function test_index_method_is_not_functional_with_wrong_role()
    {
        // Create a user with a random role (0-3)
        $user = User::factory()->create([
            'role' => rand(0, 3)
        ]);

        // we create a mocking  user
        $mock_user = $this->actingAs($user);

        // Create an instance of the AdministrateurController
        $controller = new AdministrateurController($mock_user);

        // Call the index method
        $response = $controller->index();

        // Assert that the response status code is 403 (Forbidden)
        assertSame($response->status(), 403, 'User does not have correct permissions (role = ' . $user->role . ')');
    }

    public function test_store_is_working_with_correct_role()
    {
        // Create a user with role 4
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of Administrateur using the factory
        $admin_etab = Administrateur::factory()->make();

        // Send a JSON POST request to store the admin
        $response = $this->actingAs($admin_uni)->json('POST', 'api/admins', [
            'PPR' => $admin_etab->PPR,
            'nom' => $admin_etab->nom,
            'prenom' => $admin_etab->prenom,
            'etablissement_id' => $admin_etab->etablissement_id,
            'email_perso' => $admin_etab->email_perso
        ]);

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'The admin is not stored');
    }

    /**
     * Test if the store method in the AdministrateurController creates a user associated with the admin.
     *
     * @return void
     */
    public function test_store_is_creating_a_user_associated_to_admin()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and assign it to $admin_etab
        $admin_etab = Administrateur::factory()->make();

        // Send a POST request to create a new Administrateur record
        $response = $this->actingAs($admin_uni)->json('POST', 'api/admins', [
            'PPR' => $admin_etab->PPR,
            'nom' => $admin_etab->nom,
            'prenom' => $admin_etab->prenom,
            'etablissement_id' => $admin_etab->etablissement_id,
            'email_perso' => $admin_etab->email_perso
        ]);

        // Generate a unique email based on the admin's name
        $baseEmail = strtolower($admin_etab->prenom . '.' . $admin_etab->nom . '@payprof.com');
        $uniqueEmail = $baseEmail;
        $count = 1;

        // Check if the generated email already exists in the User table, if it does, increment the count and generate a new email
        $uniqueEmail = substr($baseEmail, 0, strrpos($baseEmail, '@')) . $count . '@payprof.com';
        while (User::where('email', $uniqueEmail)->exists()) {
            $count++;
            $uniqueEmail = substr($baseEmail, 0, strrpos($baseEmail, '@')) . $count . '@payprof.com';
        }

        // Adjust the email if a unique one was found
        if ($count == 1)
            $uniqueEmail = $baseEmail;
        else
            $uniqueEmail = substr($baseEmail, 0, strrpos($baseEmail, '@')) . --$count . '@payprof.com';

        // Check if a user with the unique email exists
        $exists = User::where('email', $uniqueEmail)->first();

        // Assert that the user associated with the admin is stored
        assertNotNull($exists, 'User associated with this admin is not stored');
    }



    /**
     * Test if the update method in the AdministrateurController works correctly.
     *
     * @return void
     */
    public function test_update_method_works_correctly()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and assign it to $admin_etab
        $admin_etab = Administrateur::factory()->make();

        // Send a POST request to create a new Administrateur record
        $response = $this->actingAs($admin_uni)->json('POST', 'api/admins', [
            'PPR' => $admin_etab->PPR,
            'nom' => $admin_etab->nom,
            'prenom' => $admin_etab->prenom,
            'etablissement_id' => $admin_etab->etablissement_id,
            'email_perso' => $admin_etab->email_perso
        ]);

        // Get the ID of the created Administrateur
        $admin_id = Administrateur::where("PPR", $admin_etab->PPR)->first()->id;

        // Send a PATCH request to update the Administrateur record
        $resp = $this->json('PATCH', 'api/admins/' . $admin_id, [
            'PPR' => $admin_etab->PPR,
            'nom' => $admin_etab->nom . '.test',
            'prenom' => $admin_etab->prenom,
            'etablissement_id' => $admin_etab->etablissement_id,
            'email_perso' => $admin_etab->email_perso
        ]);

        // Assert that the response status code is 200 (OK)
        $resp->assertStatus(200);
    }

    /**
     * Test if the show method in the AdministrateurController works correctly.
     *
     * @return void
     */
    public function test_show_Administrateur_works_correctly()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and save it to the database
        $admin = Administrateur::factory()->create();

        // Send a GET request to retrieve the created Administrateur record
        $response = $this->actingAs($admin_uni)->get('api/admins/' . $admin->id);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Test if the destroy method in the AdministrateurController works properly.
     *
     * @return void
     */
    public function test_destroy_works_properly()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);
        // Create a new instance of the Administrateur model using the factory and save it to the database
        $admin = Administrateur::factory()->create();

        // Send a DELETE request to delete the Administrateur record
        $response = $this->actingAs($admin_uni)->json('DELETE', 'api/admins/' . $admin->id);

        // Assert that the Administrateur record is not found in the database
        assertNull(Administrateur::where('id', $admin->id)->first());

        // Assert that the status code of the response is 200 (OK)
        assertSame($response->status(), 200, "Administrateur not deleted!!!");
    }

    /**
     * Test if the ShowMyProfil method in the AdministrateurController works properly.
     *
     * @return void
     */
    public function test_show_my_profile_is_functional()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and save it to the database
        $admin = Administrateur::factory()->create();

        // Send a GET request to retrieve the current user's profile
        $response = $this->actingAs($admin_uni)->json('GET', 'api/admins/' . $admin->user_id . '/myprofile');

        // Assert that the user_id in the response matches the user_id of the Administrateur record
        assertSame($response->getData()->data->user_id, $admin->user_id, "Show profile method is not fully functional");
    }

    /**
     * Test if the updateemail method in the AdministrateurController updates email correctly.
     *
     * @return void
     */
    public function test_update_email_is_working_correctly()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and save it to the database
        $admin = Administrateur::factory()->create();

        // Generate a new email by appending 'test' to the existing email
        $new_email = 'test.' . $admin->email_perso;

        // Send a PUT request to update the email of the Administrateur
        $response = $this->actingAs($admin_uni)->json('PUT', 'api/admins/' . $admin->user_id . '/updateemail', [
            'email_perso' => $new_email
        ]);

        // Retrieve the updated email from the database
        $admin_updated_email = Administrateur::where('PPR', $admin->PPR)->orderBy('PPR', 'DESC')->first()->email_perso;

        // Assert that the email in the database matches the updated email
        assertEquals($new_email, $admin_updated_email, 'Email not updated correctly');
    }

    /**
     * Test if the showenseignants method in the AdministrateurController works correctly.
     *
     * @return void
     */
    public function test_update_all_enseignants_is_working_correctly()
    {
        $admin_uni = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Administrateur model using the factory and save it to the database
        $admin = Administrateur::factory()->create();

        // Send a GET request to retrieve all enseignants
        $response = $this->actingAs($admin_uni)->json('GET', 'api/admins/' . $admin->user_id . '/showenseignants');

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'showenseignants not working correctly');
    }
}
