<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NivelprioridadController;
use App\Http\Controllers\EstadoticketController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SeguimientoticketController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/* ###########################################
 * USERS
   ###########################################*/


  Route::post('/users',[UserController::class,'store']);
  Route::post('/login',[UserController::class,'login']);
 


  Route::middleware('auth:api')->group(function () {
    Route::post('/logout',[UserController::class,'logout']);
    Route::post('/validarusuario',[UserController::class,'validarUsuario']);
    Route::apiResource('/nprioridad',NivelprioridadController::class);
    Route::apiResource('/ticket',TicketController::class);
    Route::get('/get_tickets',[TicketController::class,'get_tickets']);
    Route::get('/buscar_registros/{titulo?}/{fecha_inicio?}/{fecha_final?}/{prioridad?}/{estado?}',[TicketController::class,'buscarregistro']);
    Route::get('/gestionar_tickets/{titulo?}/{fecha_inicio?}/{fecha_final?}/{prioridad?}/{estado?}',[TicketController::class,'gestionar_tickets']);
    Route::apiResource('/estado',EstadoticketController::class);
    Route::post('/getfile',[FileController::class,'anexos_ticket']);
    Route::apiResource('/historicoticket',SeguimientoticketController::class);

  });





  





/* Rutas para Tickets */
Route::apiResource('tickets',TicketController::class);


