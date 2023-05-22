<?php

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\api\EnseignantController;
use App\Http\Controllers\api\EtablissementController;
use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\InterventionController;
use App\Http\Controllers\api\PaiementsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirecteurController;

route::apiResource('ens',EnseignantController::class);
//route of  ShowMyInterventions
route::get('ens/{ens}/inter',[EnseignantController::class,'ShowMyInterventions']);
//route of  ShowMyPayments
route::get('ens/{ens}/pay',[EnseignantController::class,'ShowMyPayments']);

route::apiResource('adm',AdministrateurController::class);

route::apiResource('grd',GradeController::class);
route::apiResource('direct',DirecteurController::class);

route::apiResource('int',InterventionController::class);

route::apiResource('pay',PaiementsController::class);

route::apiResource('etab',EtablissementController::class);









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
route::post('/login',[AuthController::class,'login']);

route::group(['middleware'=>['auth:sanctum']],function(){
    route::get('/logout',[AuthController::class,'logout']);
    route::get('/refrech',[AuthController::class,'refreshToken']);
    
}
);