<?php

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\api\EnseignantController;
use App\Http\Controllers\api\EtablissementController;
use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\InterventionController;
use App\Http\Controllers\api\PaiementsController;
use App\Http\Controllers\api\DirecteurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//====================================Enseignant API ==================================================
route::apiResource('Enseignant',EnseignantController::class);
//route of  ShowMyInterventions
route::get('Enseignant/{Enseignant}/MyIntervention',[EnseignantController::class,'ShowMyInterventions']);
//route of  ShowMyPayments
route::get('Enseignant/{Enseignant}/MyPayments',[EnseignantController::class,'ShowMyPayments']);
//route of UploadMyImage
route::POST('Enseignant/{Enseignant}/UploadMyImage',[EnseignantController::class,'UploadMyImage']);
//route of ShowMyProfil
route::get('Enseignant/{Enseignant}/ShowMyProfil',[EnseignantController::class,'ShowMyProfil']);
//route of MyHours
route::get('Enseignant/{Enseignant}/MyHours',[EnseignantController::class,'MyHours']);
//route of UpdateMyEmail
route::PATCH('Enseignant/{Enseignant}/UpdateMyEmail',[EnseignantController::class,'UpdateMyEmail']);

//=====================================================================================================

route::apiResource('adm',AdministrateurController::class);

route::apiResource('grd',GradeController::class);



route::apiResource('int',InterventionController::class);
//route of showmore details about an intervention
route::get('int/{int}/showmore',[InterventionController::class ,'ShowMore']);
//route of the activation of the visUAE
route::PATCH('int/{int}/visauae',[InterventionController::class ,'activeVisaUae']);
//route of the activation of the visETAb
route::PATCH('int/{int}/visaetab',[InterventionController::class ,'activeVisaEtab']);
//route of the ShowMyEtabInterventions
route::get('ShowMyEtabInterventions',[InterventionController::class ,'ShowMyEtabInterventions']);



route::apiResource('pay',PaiementsController::class);

route::apiResource('etab',EtablissementController::class);



//============================================ Diresteur API ============================================
route::apiResource('dir',DirecteurController::class);
//route of UploadMyImage
route::POST('dir/{dir}/UploadMyImage',[DirecteurController::class,'UploadMyImage']);
//route of ShowMyProfil
route::get('dir/{dir}/ShowMyProfil',[DirecteurController::class,'ShowMyProfil']);
//route of UpdateMyEmail
route::PATCH('dir/{dir}/UpdateMyEmail',[DirecteurController::class,'UpdateMyEmail']);

//=======================================================================================================




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});