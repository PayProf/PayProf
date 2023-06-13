<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\PaiementsController;
use App\Models\Paiements;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework;


class PaiementTest extends TestCase
{

    /**
     * Test if the index method in the PaiementController is functional.
     *
     * @return void
     */
    public function test_index_Paiement_works_correctly()
    {
        // Create a User using the factory as an admin and president of UAE
        $user = User::factory()->create([
            'role' => rand(3, 4)
        ]);
        // Create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Send a GET request to the 'api/paiements' endpoint
        $response = $mock_user->get('api/paiements');

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Test if the show method in the PaiementController is up and running for a specific Paiement.
     *
     * @return void
     */
    public function test_show_specific_Paiement_is_up_and_running()
    {
        // Create a User using the factory as an admin or as a enseignant (role 0)
        $user = User::factory()->create([
            'role' => 4
        ]);
        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Paiement model using the factory
        $paiement = Paiements::factory()->create();
        // Send a GET request to the 'api/paiements/{$id}' endpoint
        $response = $mock_user->get('api/paiements/' . $paiement->id);
        //dd($response);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }


    /**
     * Test if the show method in the PaiementController doesn't work
     * with wrong permissions
     * @return void
     */
    public function test_show_specific_Paiement_does_not_work_with_wrong_permissions()
    {
        // Create a User using the factory with permissions diffrent from 4 (admin)
        $user = User::factory()->create([
            'role' => rand(0, 3)
        ]);
        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Paiement model using the factory
        $paiement = Paiements::factory()->create();
        // Send a GET request to the 'api/paiements/{$id}' endpoint
        $response = $mock_user->get('api/paiements/' . $paiement->id);
        //dd($response);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(403);
    }
}
