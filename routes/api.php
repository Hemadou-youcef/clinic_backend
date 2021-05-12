<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/patients' , [\App\Http\Controllers\PatientController::class , 'index']);
Route::post('/login' , [\App\Http\Controllers\LoginController::class , 'login']  );
Route::post('/logout' , [\App\Http\Controllers\LoginController::class , 'logout']  );

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/image/{patient}' , [\App\Http\Controllers\UpdateImageController::class , 'store']);
//    Route::get('/patients' , [\App\Http\Controllers\PatientController::class , 'index']);
    Route::get('/patient/{id}', [\App\Http\Controllers\PatientController::class, 'show']);
    Route::post('/patient/create', [\App\Http\Controllers\PatientController::class, 'store']);
    Route::post('/patient/delete/{patient}', [\App\Http\Controllers\PatientController::class, 'destroy']);
    Route::post('/patient/update/{patient}', [\App\Http\Controllers\PatientController::class, 'update']);

    Route::get('/appointments/all',[\App\Http\Controllers\AppointmentController::class , 'getAllAppointments']);
    Route::post('/appointment/add',[\App\Http\Controllers\AppointmentController::class , 'AddAppointment']);
    Route::post('/appointment/edit',[\App\Http\Controllers\AppointmentController::class , 'EditAppointment']);
    Route::post('/appointment/delete',[\App\Http\Controllers\AppointmentController::class , 'DeleteAppointment']);
    Route::get('/allpatients',[\App\Http\Controllers\PatientController::class , 'getAllPatient']);
});

Route::get('/appointments/range',[\App\Http\Controllers\AppointmentController::class , 'getRangeAppointments']);



Route::get('/password' , function (){

    return \Illuminate\Support\Facades\Hash::make('samisamo');
});
Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/date' , function (){
    $datetime = new DateTime(now());
//    $datetime->modify('+1 day');
    return $datetime->format('Y-m-d H:i:s');
});

