<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NivelprioridadController;
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
   

  });


  Route::apiResource('/nprioridad',NivelprioridadController::class);





/* Rutas para Tickets */
Route::apiResource('tickets',TicketController::class);


