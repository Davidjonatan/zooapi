<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\animal_Controller;
use App\Http\Controllers\sanctumController;
use App\Http\Controllers\especie_Controller;
use App\Http\Controllers\habitat_Controller;
use App\Http\Controllers\empleado_Controller;
use App\Http\Controllers\registrosalud_Controller;
use App\Http\Controllers\programacrianza_controller;
use App\Http\Controllers\dieta_controller;


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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("logout", [SanctumController::class, "logout"])->middleware('auth:sanctum');
Route::post("login",[sanctumController::class,"login"]);
//******************************************************* */
//******************************************************* */
Route::middleware('auth:sanctum')->group(function () {
Route::post('/animal', [animal_Controller::class, 'index']);
Route::get('/animal/{id}', [animal_Controller::class, 'show']);    
Route::put('/animal/{id}', [animal_Controller::class, 'update']);   
Route::delete('/animal/{id}', [animal_Controller::class, 'destroy']);
Route::post('/animal/restore/{id}', [animal_Controller::class, 'restore']);
//******************************************************** */
//******************************************************** */    
Route::post('/especie', [especie_Controller::class, 'index']);
Route::get('/especie/{id}', [especie_Controller::class, 'show']);    
Route::put('/especie/{id}', [especie_Controller::class, 'update']);   
Route::delete('/especie/{id}', [especie_Controller::class, 'destroy']);
Route::post('/especie/restore/{id}', [especie_Controller::class, 'restore']);
//******************************************************** */
//******************************************************** */
Route::post('/habitat', [habitat_Controller::class, 'index']);
Route::get('/habitat/{id}', [habitat_Controller::class, 'show']);    
Route::put('/habitat/{id}', [habitat_Controller::class, 'update']);   
Route::delete('/habitat/{id}', [habitat_Controller::class, 'destroy']);
Route::post('/habitat/restore/{id}', [habitat_Controller::class, 'restore']);
//******************************************************** */
//******************************************************** */
Route::post('/empleado', [empleado_Controller::class, 'index']);
Route::get('/empleado/{id}', [empleado_Controller::class, 'show']);    
Route::put('/empleado/{id}', [empleado_Controller::class, 'update']);   
Route::delete('/empleado/{id}', [empleado_Controller::class, 'destroy']);
Route::post('/empleado/restore/{id}', [empleado_Controller::class, 'restore']);
//******************************************************** */
//******************************************************** */
Route::post('/registro', [registrosalud_Controller::class, 'index']);
Route::get('/registro/{id}', [registrosalud_Controller::class, 'show']);    
Route::put('/registro/{id}', [registrosalud_Controller::class, 'update']);   
Route::delete('/registro/{id}', [registrosalud_Controller::class, 'destroy']);
Route::post('/registro/restore/{id}', [registrosalud_Controller::class, 'restore']);
//******************************************************** */
//******************************************************** */
Route::post('/crianza', [programacrianza_controller::class, 'index']);
Route::get('/crianza/{id}', [programacrianza_controller::class, 'show']);    
Route::put('/crianza/{id}', [programacrianza_controller::class, 'update']);   
Route::delete('/crianza/{id}', [programacrianza_controller::class, 'destroy']);
Route::post('/crianza/restore/{id}', [programacrianza_controller::class, 'restore']);
//******************************************************** */
//******************************************************** */
Route::post('/dieta', [dieta_Controller::class, 'index']);
Route::get('/dieta/{id}', [dieta_Controller::class, 'show']);    
Route::put('/dieta/{id}', [dieta_Controller::class, 'update']);   
Route::delete('/dieta/{id}', [dieta_Controller::class, 'destroy']);
Route::post('/dieta/restore/{id}', [dieta_Controller::class, 'restore']);
});