<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/patients', [\App\Http\Controllers\PatientController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/image/{patient}', [\App\Http\Controllers\UpdateImageController::class, 'store']);
//    Route::get('/patients' , [\App\Http\Controllers\PatientController::class , 'index']);
    Route::get('/patient/{id}', [\App\Http\Controllers\PatientController::class, 'show']);
    Route::post('/patient/create', [\App\Http\Controllers\PatientController::class, 'store']);
    Route::post('/patient/delete/{patient}', [\App\Http\Controllers\PatientController::class, 'destroy']);
    Route::post('/patient/update/{patient}', [\App\Http\Controllers\PatientController::class, 'update']);


    Route::post('/appointment/add', [\App\Http\Controllers\AppointmentController::class, 'AddAppointment']);
    Route::post('/appointment/edit', [\App\Http\Controllers\AppointmentController::class, 'EditAppointment']);
    Route::post('/appointment/delete', [\App\Http\Controllers\AppointmentController::class, 'DeleteAppointment']);
    Route::get('/allpatients', [\App\Http\Controllers\PatientController::class, 'getAllPatient']);



    Route::get('/medicines', [\App\Http\Controllers\MedicineController::class , 'index']);
    Route::post('/medicines/add', [\App\Http\Controllers\MedicineController::class , 'store']);
    Route::post('/medicines/update/{medicine}', [\App\Http\Controllers\MedicineController::class , 'update']);
    Route::post('/medicines/delete/{medicine}', [\App\Http\Controllers\MedicineController::class , 'delete']);

});

Route::get('/appointments/range', [\App\Http\Controllers\AppointmentController::class, 'getRangeAppointments']);

Route::get('/appointments/statistique', [\App\Http\Controllers\AppointmentController::class, 'AppointmentStatistiqueInfo']);

Route::post('/consultation/add', [\App\Http\Controllers\ConsultationController::class, 'AddConsultation']);
Route::get('/consultation/all', [\App\Http\Controllers\ConsultationController::class, 'getAllConsultations']);

Route::get('/appointments/all', [\App\Http\Controllers\AppointmentController::class, 'getAllAppointments']);
Route::get('/password', function () {

    return \Illuminate\Support\Facades\Hash::make('12345661');
});
Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/date', function () {
    $datetime = new DateTime(now());
//    $datetime->modify('+1 day');
    return $datetime->format('Y-m-d H:i:s');
});

