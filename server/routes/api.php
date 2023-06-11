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
route::get('Enseignant/ens/MyIntervention',[EnseignantController::class,'ShowMyInterventions']);
//route of  ShowMyPayments
route::get('Enseignant/ens/MyPayments',[EnseignantController::class,'ShowMyPayments']);
//route of UploadMyImage
route::POST('Enseignant/ens/UploadMyImage',[EnseignantController::class,'UploadMyImage']);
//route of ShowMyProfil
route::get('Enseignant/ens/ShowMyProfil',[EnseignantController::class,'ShowMyProfil']);
//route of MyHours
route::get('Enseignant/ens/MyHours',[EnseignantController::class,'MyHours']);
//route of UpdateMyEmail
route::PATCH('Enseignant/ens/UpdateMyEmail',[EnseignantController::class,'UpdateMyEmail']);

//=====================================================================================================


route::apiResource('adm',AdministrateurController::class);

route::apiResource('grd',GradeController::class);



//====================================== Intervention API ===========================================

route::apiResource('Intervention',InterventionController::class);
//route of showmore
route::get('Intervention/{Intervention}/showmore',[InterventionController::class ,'ShowMore']);
//route of the activation of the visaUAE
route::PATCH('Intervention/{Intervention}/visauae',[InterventionController::class ,'activeVisaUae']);
//route of the activation of the visaETAb
route::PATCH('Intervention/{Intervention}/visaetab',[InterventionController::class ,'activeVisaEtab']);
//route of the ShowMyEtabInterventions
route::get('Intervention/int/ShowMyEtabInterventions',[InterventionController::class ,'ShowMyEtabInterventions']);
//route of EnseignantInterventions
route::get('Intervention/{Intervention}/EnseignantInterventions',[InterventionController::class,'EnseignantInterventions']);

//======================================================================================================

route::apiResource('pay',PaiementsController::class);

route::apiResource('etab',EtablissementController::class);



//============================================ Directeur API ============================================

route::apiResource('Directeur',DirecteurController::class);
//route of UploadMyImage
route::POST('Directeur/dir/UploadMyImage',[DirecteurController::class,'UploadMyImage']);
//route of ShowMyProfil
route::get('Directeur/dir/ShowMyProfil',[DirecteurController::class,'ShowMyProfil']);
//route of UpdateMyEmail
route::PATCH('Directeur/dir/UpdateMyEmail',[DirecteurController::class,'UpdateMyEmail']);

//=======================================================================================================




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});