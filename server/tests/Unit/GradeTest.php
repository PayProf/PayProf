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
    
    public function test_index_method_is_functional()
    { 
        $controller = new GradeController();
        $response = $controller->index();
        // dd($response);
        $response->assertStatus(200);
    }

    public function test_store_is_working()
    {
        $grade = Grade::factory()->make();
        $data = [
            'Designation' => $grade->designation,
            'ChargeStatutaire' => $grade->charge_statutaire,
            'TauxHoraireVacation' => $grade->Taux_horaire_vacation
        ];
        $request = $this->json('post', 'api/Grade', $data);
        assertSame($request->status(), 200, '  ');
    }

    public function test_show_specific_grade_is_up_and_running()
    {
        $response = $this->json('GET', 'api/Grade/2');
        assertSame($response->status(), 200, ' ');
    }

    public function test_update_grade_is_running()
    {
        $grade = Grade::find(4);
        $data = [
            'Designation' => $grade->designation . "test" ,
            'ChargeStatutaire' => $grade->charge_statutaire,
            'TauxHoraireVacation' => $grade->Taux_horaire_vacation
        ];
        $response = $this->json('PATCH', 'api/Grade/' . $grade->id, $data);
        $response->assertStatus(200);
        $grade_designation = Grade::find(4)->designation;
        // dd($grade_designation, $data["Designation"]);
        assertSame($grade_designation, $data["Designation"], ' ');
    }

    public function test_destroy_method_works_correctly()
    {
        $grade = Grade::first();
        $controller = new GradeController();
        $response = $controller->destroy($grade->id);
        assertNull(Grade::where("id", $grade->id)->first());
    }
}
