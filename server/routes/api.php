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
use App\Http\Controllers\AuthController;

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
route::apiResource('direct',DirecteurController::class);



//====================================== Intervention API ===========================================

route::apiResource('Intervention',InterventionController::class);
//route of showmore
route::get('Intervention/{Intervention}/showmore',[InterventionController::class ,'ShowMore']);
//route of the activation of the visaUAE
route::PATCH('Intervention/{Intervention}/visauae',[InterventionController::class ,'activeVisaUae']);
//route of the activation of the visaETAb
route::PATCH('Intervention/{Intervention}/visaetab',[InterventionController::class ,'activeVisaEtab']);
//route of the ShowMyEtabInterventions
route::get('ShowMyEtabInterventions',[InterventionController::class ,'ShowMyEtabInterventions']);
//route of EnseignantInterventions
route::get('Interventiont/{Intervention}/EnseignantInterventions',[InterventionController::class,'EnseignantInterventions']);

//======================================================================================================

route::apiResource('pay',PaiementsController::class);

route::apiResource('etab',EtablissementController::class);




//============================================ Directeur API ============================================

route::apiResource('Directeur',DirecteurController::class);
//route of UploadMyImage
route::POST('Directeur/{Directeur}/UploadMyImage',[DirecteurController::class,'UploadMyImage']);
//route of ShowMyProfil
route::get('Directeur/{Directeur}/ShowMyProfil',[DirecteurController::class,'ShowMyProfil']);
//route of UpdateMyEmail
route::PATCH('Directeur/{Directeur}/UpdateMyEmail',[DirecteurController::class,'UpdateMyEmail']);

//=======================================================================================================





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
route::post('/login',[AuthController::class,'login']);

route::group(['middleware'=>['auth:sanctum']],function(){
    route::get('/logout',[AuthController::class,'logout']);
    route::get('/refrech',[AuthController::class,'refreshToken']);
}
);
