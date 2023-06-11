<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\api\EtablissementController;
use App\Http\Controllers\AuthController;
use App\Http\Requests\StoreEtablissementRequest;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertNull;



class EtablissementTest extends TestCase
{
    public function test_index_method_is_functional()
    {
        $controller = new EtablissementController();
        $response = $controller->index();
        assertSame($response->status(), 200, 'index is not working');
    }

    public function test_store_is_working()
    {
        $etab = Etablissement::factory()->make();
        $data = [
            'nom' => $etab->nom,
            'code' => $etab->code,
            'telephone' => $etab->telephone,
            'FAX' => $etab->FAX,
            'ville' => $etab->ville
        ];
        // $controller = new EtablissementController();
        $request = $this->json('post', 'api/etablissements', $data);
        assertSame($request->status(), 200, '  ');
    }

    public function test_show_specific_etablissement_is_up_and_running()
    {
        $response = $this->json('GET', 'api/etablissements/8?with=Enseignants');
        assertSame($response->status(), 200, ' ');
    }

    public function test_update_etablissement_is_running()
    { 
        $etab = Etablissement::find(9);
        $data = [
            'nom' => $etab->nom . 'test',
            'code' => $etab->code,
            'telephone' => $etab->telephone,
            'FAX' => $etab->FAX,
            'ville' => $etab->ville
        ];
        $response = $this->json('PATCH', 'api/etablissements/' . $etab->id, $data);
        $etab_nom = Etablissement::find(9)->nom;
        assertSame($etab_nom, $data["nom"], ' ');
    }

    public function test_destroy_method_works_correctly()
    {
        $etab = Etablissement::first();
        $controller = new EtablissementController();
        $response = $controller->destroy($etab->id);
        assertNull(Etablissement::where("code", $etab->code)->first());
    }

    public function test_show_my_etablissements()
    {
        $user = User::find(12);
        $controller = new EtablissementController();
        $response = $controller->Show_Myetablissement($user->id, $user->role);
    }
}