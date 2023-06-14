<?php

namespace Tests\Unit;

use App\Models\Administrateur;
use App\Models\Directeur;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;


use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

class DirecteurTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index_method_is_functional()
    {
        // Create a user with role 4
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // we create a mocking  user
        $mock_user  = $this->actingAs($user);

        // Create an instance of the DirecteurController
        $response = $mock_user->get('api/Directeur');

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'user method does not have correct permissions');
    }
    public function test_index_method_is_not_functional_with_wrong_roles()
    {
        // Create a user with role 4
        $user = User::factory()->create([
            'role' => 2
        ]);

        // we create a mocking  user
        $mock_user  = $this->actingAs($user);

        // Create an instance of the DirecteurController
        $response = $mock_user->get('api/Directeur');

        // Assert that the response status code is 403 (Forbidden)
        assertSame($response->status(), 403, 'User does not have correct permissions (role = ' . $user->role . ')');
    }

    public function test_store_is_working_with_correct_role()
    {
        // Create a user with role 4
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm =
            Administrateur::factory()->create([
                'user_id' => $admin_etab->id,
            ]);

        // Create a new instance of Directeur using the factory
        $dir_etab = Directeur::factory()->make();

        // Send a JSON POST request to store the admin
        $response = $this->actingAs($admin_etab)->json('POST', 'api/Directeur', [
            'PPR' => $dir_etab->PPR,
            'nom' => $dir_etab->nom,
            'prenom' => $dir_etab->prenom,
            'DateNaissance' => $dir_etab->date_naissance,
            'email_perso' => $dir_etab->email_perso
        ]);

        // Assert that the response status code is 200 (OK)
        assertSame($response->status(), 200, 'The admin is not stored');
    }
    public function test_store_is_creating_a_user_associated_to_directeur()
    {
        $admin_etab = User::factory()->create([
            'role' => 2
        ]);
        $adm =
            Administrateur::factory()->create([
                'user_id' => $admin_etab->id,
            ]);

        // Create a new instance of the Directeur model using the factory and assign it to $admin_etab
        $dir_etab = Directeur::factory()->make();

        // Send a POST request to create a new Directeur record
        $response = $this->actingAs($admin_etab)->json('POST', 'api/Directeur', [
            'PPR' => $dir_etab->PPR,
            'nom' => $dir_etab->nom,
            'prenom' => $dir_etab->prenom,
            'DateNaissance' => $dir_etab->date_naissance,
            'email_perso' => $dir_etab->email_perso
        ]);

        // Generate a unique email based on the admin's name
        $baseEmail = strtolower($dir_etab->prenom . '.' . $dir_etab->nom . '@payprof.com');
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
        assertNotNull($exists, 'User associated with this directeur is not stored');
    }
    public function test_show_Directeur_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => rand(3, 4)
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $dir_etab = Directeur::factory()->create();

        // Send a GET request to retrieve the created Directeur record
        $response = $this->actingAs($admin_etab)->get('api/Directeur/' . $dir_etab->id);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }
    public function test_update_method_works_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $dir_etab = Directeur::factory()->create();


        // Send a PATCH request to update the Directeur record
        $resp = $this->actingAs($admin_etab)->json(
            'PUT',
            'api/Directeur/' . $dir_etab->id,
            [
                'PPR' => $dir_etab->PPR + 1,
                'nom' => $dir_etab->nom . '.test',
                'prenom' => $dir_etab->prenom,
                'DateNaissance' => $dir_etab->date_naissance,
                'email_perso' => 'test' . $dir_etab->email_perso
            ]
        );

        // Assert that the response status code is 200 (OK)
        $resp->assertStatus(200);
    }
    public function test_destroy_works_properly()
    {
        $admin_etab = User::factory()->create([
            'role' => 4
        ]);
        // Create a new instance of the Directeur model using the factory and save it to the database
        $dir_etab = Directeur::factory()->create();

        // Send a DELETE request to delete the Directeur record
        $response = $this->actingAs($admin_etab)->json('DELETE', 'api/Directeur/' . $dir_etab->id);
        // if ($directeur->image)
        // Assert that the Directeur record is not found in the database
        assertNull(Directeur::where('id', $dir_etab->id)->first());

        // Assert that the status code of the response is 200 (OK)
        assertSame($response->status(), 200, "Directeur not deleted!!!");
    }
    public function test_update_email_is_working_correctly()
    {
        $admin_etab = User::factory()->create([
            'role' => 1
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $dir_etab = Directeur::factory()->create([
            'user_id' => $admin_etab->id
        ]);

        // Generate a new email by appending 'test' to the existing email
        $new_email = 'test.' . $dir_etab->email_perso;

        // Send a PUT request to update the email of the Directeur
        $response = $this->actingAs($admin_etab)->json('PATCH', 'api/Directeur/dir/UpdateMyEmail', [
            'email_perso' => $new_email
        ]);

        // Retrieve the updated email from the database
        $dir_updated_email = Directeur::where('PPR', $dir_etab->PPR)->orderBy('PPR', 'DESC')->first()->email_perso;

        // Assert that the email in the database matches the updated email
        assertEquals($new_email, $dir_updated_email, 'Email not updated correctly');
    }
    public function test_show_my_profile_is_functional()
    {
        $admin_etab = User::factory()->create([
            'role' => 1
        ]);

        // Create a new instance of the Directeur model using the factory and save it to the database
        $dir_etab = Directeur::factory()->create([
            'user_id' => $admin_etab->id
        ]);
        // Send a GET request to retrieve the current user's profile
        $response = $this->actingAs($admin_etab)->json('GET', 'api/Directeur/dir/ShowMyProfil');

        // Assert that the user_id in the response matches the user_id of the Directeur record
        assertSame($response->getData()->data->IdUser, $dir_etab->user_id, "Show profile method is not fully functional");
    }

    public function test_upload_image_is_working_correctly()
    {
        $user = User::factory()->create([
            'role' => 1
        ]);
        $dir_etab = Directeur::factory()->create([
            "user_id" => $user->id,
        ]);
        // Set up a fake local storage for testing
        Storage::fake('local');

        // Create a fake uploaded file named 'test.png'
        $file = UploadedFile::fake()->create('test.png');

        // Send a JSON POST request to the 'api/directeur/6/UploadMyImage' endpoint with the file
        $response = $this->actingAs($user)->json(
            'post',
            'api/Directeur/dir/UploadMyImage',
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
}
