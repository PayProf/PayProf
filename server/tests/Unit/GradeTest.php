<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\AuthController;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

class GradeTest extends TestCase
{

    /**
     * Test if the index method in the GradeController is functional.
     *
     * @return void
     */
    public function test_index_Grade_works_correctly()
    {
        // Create a User using the factory
        $user = User::factory()->create();
        // Create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Send a GET request to the 'api/Grade' endpoint
        $response = $mock_user->get('api/Grade');

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Test if the store method in the GradeController is working.
     *
     * @return void
     */

    public function test_store_method_works_correctly()
    {
        // Create a User using the factory as an admin
        $user = User::factory()->create([
            'role' => 4
        ]);

        // Create a new instance of the Grade model using the factory
        $grade = Grade::factory()->make();

        // Send a JSON POST request to the 'api/Grade' endpoint with the specified data
        $response = $this->actingAs($user)->json('POST', 'api/Grade', [
            'Designation' => $grade->designation,
            'ChargeStatutaire' => $grade->charge_statutaire,
            'TauxHoraireVacation' => $grade->Taux_horaire_vacation
        ]);

        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }


    /**
     * Test if the store method in the GradeController doesn't store with
     * wrong permissions
     * @return void
     */

    public function test_store_method_does_not_work_with_wrong_permissions()
    {
        // Create a User using the factory with permissions diffrent from 4 (admin)
        $user = User::factory()->create([
            'role' => rand(0, 3)
        ]);

        // Create a new instance of the Grade model using the factory
        $grade = Grade::factory()->make();

        // Send a JSON POST request to the 'api/Grade' endpoint with the specified data
        $response = $this->actingAs($user)->json('POST', 'api/Grade', [
            'Designation' => $grade->designation,
            'ChargeStatutaire' => $grade->charge_statutaire,
            'TauxHoraireVacation' => $grade->Taux_horaire_vacation
        ]);

        // Assert that the response status code is 403 (Acces interdit)
        $response->assertStatus(403);
    }


    /**
     * Test if the show method in the GradeController is up and running for a specific grade.
     *
     * @return void
     */
    public function test_show_specific_grade_is_up_and_running()
    {
        // Create a User using the factory
        $user = User::factory()->create();
        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Grade model using the factory
        $grade = Grade::factory()->create();
        // Send a GET request to the 'api/Grade/{$id}' endpoint
        $response = $mock_user->get('api/Grade/' . $grade->id);
        //dd($response);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Test if the update method in the GradeController is running properly.
     *
     * @return void
     */
    public function test_update_grade_is_running()
    {
        // Create a User using the factory as an admin
        $user = User::factory()->create([
            'role' => 4
        ]);
        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Grade model using the factory
        $grade = Grade::factory()->create();
        // Changed Designation
        $data = [
            'Designation' => $grade->designation . "test",
            'ChargeStatutaire' => $grade->charge_statutaire,
            'TauxHoraireVacation' => $grade->Taux_horaire_vacation
        ];
        $response = $mock_user->json('patch', 'api/Grade/' . $grade->id, $data);
        //dd($response);
        // Assert that the response status code is 200 (OK)
        $response->assertStatus(200);
        //find the updated grade 
        $grade_designation = Grade::find($grade->id)->designation;
        // Assert that the designation of garde after update is as same as the changed designation
        assertSame($grade_designation, $data["Designation"], 'Designation does not match');
    }

    /**
     * Test if the destroy method in the GradeController works correctly.
     *
     * @return void
     */

    public function test_delete_grade_is_running()
    {
        // Create a User using the factory as an admin
        $user = User::factory()->create([
            'role' => 4
        ]);
        // we create a mocking  user
        $mock_user  = $this->actingAs($user);
        // Create a new instance of the Grade model using the factory
        $grade = Grade::factory()->create();

        $response = $mock_user->json('delete', 'api/Grade/' . $grade->id);
        //dd($grade);
        $response->assertStatus(200);
    }
}
