<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::get('/appointments/all',[\App\Http\Controllers\AppointmentController::class , 'getAllAppointments']);
    Route::get('/appointments/range',[\App\Http\Controllers\AppointmentController::class , 'getRangeAppointments']);
    Route::post('/appointment/add',[\App\Http\Controllers\AppointmentController::class , 'AddAppointment']);
    Route::post('/appointment/edit',[\App\Http\Controllers\AppointmentController::class , 'EditAppointment']);
    Route::post('/appointment/delete',[\App\Http\Controllers\AppointmentController::class , 'DeleteAppointment']);
    Route::get('/patients',[\App\Http\Controllers\PatientController::class , 'getAllPatient']);

});
Route::post('/login' , [\App\Http\Controllers\LoginController::class , 'login']  );
Route::post('/logout' , [\App\Http\Controllers\LoginController::class , 'logout']  );

Route::get('/password' , function (){

    return \Illuminate\Support\Facades\Hash::make('12345678991');
});


