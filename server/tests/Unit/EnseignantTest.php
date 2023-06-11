<?php

namespace Tests\Unit;

use App\Models\Enseignant;
use Tests\TestCase;

use App\Http\Controllers\api\EnseignantController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Iterator\FilenameFilterIterator;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileEquals;
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
        $response = $this->get('api/Enseignant');
        $response->assertStatus(200);
    }

    public function test_store_method_works_correctly()
    {
        $ens = Enseignant::factory()->make();
        $response = $this->json('POST', 'api/Enseignant', [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom,
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
            'email_perso' => $ens->email_perso
        ]);
        $response->assertStatus(200);
    }

    public function test_show_enseignant_works_correctly()
    {
        $ens = Enseignant::factory()->create();
        $response = $this->get('api/Enseignant/' . $ens->id);
        $response->assertStatus(200);
    }

    public function test_update_method_works_correctly()
    {
        $ens = Enseignant::factory()->make();
        $response = $this->json('POST', 'api/Enseignant', [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom,
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
            'email_perso' => $ens->email_perso
        ]);
        $response->assertStatus(200);
        $ens_id = Enseignant::where("PPR", $ens->PPR)->first()->id;
        $resp = $this->json('PUT', 'api/Enseignant/' . $ens_id, [
            'PPR' => $ens->PPR,
            'nom' => $ens->nom . "|",
            'prenom' => $ens->prenom,
            "DateNaissance" => $ens->date_naissance,
            'Grade' => "Jacky Daniel",
            //'email_perso' => $ens->email_perso

        ]);
        $resp->assertStatus(200);
    }

    public function test_destroy_works_properly()
    {
        $ens = Enseignant::factory()->create();
        $response = new EnseignantController();
        $re = $response->destroy($ens->id)->status();
        assertSame($re, 200, "Enseignant not deleted !!!");
    }

    public function test_show_my_intervention_is_functional()
    {
        //$random_user_id = rand(2, 26);

        $response = new EnseignantController();
        $res = $response->ShowMyInterventions(6)->status();
        assertSame($res, 200, "interventions method is not fully functional");
    }
    public function test_show_payments_is_working_correctly()
    {
        // $random_user_id = rand(2, 26);
        // $random_user = Enseignant::where('id', $random_user_id)->first();
        $response = new EnseignantController();
        $res = $response->ShowMyPayments(6);
        $data_returned = $res->getData()->data->paiements;
        // if (empty($data_returned))
        //     assertSame($res->status(), 404, "payments method is not fully functional");
        // else
        assertSame($res->status(), 200, "payments method is not fully functional");
    }

    public function test_upload_image_is_working_correctly()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->create('test.png');

        $response = $this->json(
            'post',
            'api/Enseignant/6/UploadMyImage',
            [
                'image' => $file
            ]
        );
        $filename = time() . '_' . 'test.png';
        $file = public_path('uploads') . '/' . $filename;
        assertSame($response->status(), 200, 'the response is not 200 ');
        assertFileExists($file, "the image file is not stored ");
    }

    public function test_show_my_profile_is_functional()
    {
        //$random_user_id = rand(2, 26);
        $dump_user = Enseignant::first();
        $response = new EnseignantController();
        $res = $response->ShowMyProfil($dump_user->user_id);
        assertSame($res->PPR, $dump_user->PPR, "show profile  method is not fully functional");
    }
    public function test_show_my_hours_is_working()
    {
        //$random_user_id = rand(2, 26);
        $dump_user = Enseignant::first();
        $response = new EnseignantController();
        $res = $response->MyHours(3);
        assertSame($res->status(), 200, "interventions method is not fully functional");
    }

    public function test_update_email_is_working_correctly()
    {
        //$random_user_id = rand(2, 26);
        $dump_user = Enseignant::first();
        $nv_email = $dump_user->email_perso . 'aga';
        $resp = $this->json('PATCH', 'api/Enseignant/' . $dump_user->user_id . '/UpdateMyEmail', [
            'email_perso' => $nv_email
        ]);
        assertEquals($nv_email, Enseignant::first()->email_perso, 'email not updated ');
    }
}
