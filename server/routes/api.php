<?php

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\api\EnseignantController;
use App\Http\Controllers\api\EtablissementController;
use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\InterventionController;
use App\Http\Controllers\api\PaiementsController;
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
route::get('ens/{ens}/inter',[EnseignantController::class,'ShowMyInterventions']);
//route of  ShowMyPayments
route::get('ens/{ens}/pay',[EnseignantController::class,'ShowMyPayments']);

route::apiResource('adm',AdministrateurController::class);

//========================================= Grade API =====================================================

route::apiResource('Grade',GradeController::class);

//=========================================================================================================




route::apiResource('int',InterventionController::class);


route::apiResource('pay',PaiementsController::class);

route::apiResource('etab',EtablissementController::class);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});