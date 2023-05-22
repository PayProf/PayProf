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
route::apiResource('ens',EnseignantController::class);
//route of  ShowMyInterventions
route::get('ens/{ens}/MyIntervention',[EnseignantController::class,'ShowMyInterventions']);
//route of  ShowMyPayments
route::get('ens/{ens}/MyPayments',[EnseignantController::class,'ShowMyPayments']);
//route of UploadMyImage
route::POST('ens/{ens}/UploadMyImage',[EnseignantController::class,'UploadMyImage']);

//route::get('MyEtabProf',[EnseignantController::class,'MyEtabProf']);

//route of ShowMyProfil
route::get('ens/{ens}/ShowMyProfil',[EnseignantController::class,'ShowMyProfil']);
//route MyHours
route::get('ens/{ens}/MyHours',[EnseignantController::class,'MyHours']);
//route UpdateMyEmail
route::PATCH('ens/{ens}/UpdateMyEmail',[EnseignantController::class,'UpdateMyEmail']);

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

route::apiResource('dir',DirecteurController::class);
route::POST('ens/{ens}/UploadMyImage',[EnseignantController::class,'UploadMyImage']);
route::get('ens/{ens}/ShowMyProfil',[EnseignantController::class,'ShowMyProfil']);
route::PATCH('ens/{ens}/UpdateMyEmail',[EnseignantController::class,'UpdateMyEmail']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});