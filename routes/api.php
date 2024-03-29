<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/patients', [\App\Http\Controllers\PatientController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
    Route::post('/image/{patient}', [\App\Http\Controllers\UpdateImageController::class, 'store']);
//    Route::get('/patients' , [\App\Http\Controllers\PatientController::class , 'index']);
    Route::get('/patient/{id}', [\App\Http\Controllers\PatientController::class, 'show']);
    Route::post('/patient/create', [\App\Http\Controllers\PatientController::class, 'store']);
    Route::post('/patient/delete/{patient}', [\App\Http\Controllers\PatientController::class, 'destroy']);
    Route::post('/patient/update/{patient}', [\App\Http\Controllers\PatientController::class, 'update']);
    Route::get('/allpatients', [\App\Http\Controllers\PatientController::class, 'getAllPatient']);

    Route::post('/appointment/add', [\App\Http\Controllers\AppointmentController::class, 'AddAppointment']);
    Route::post('/appointment/edit', [\App\Http\Controllers\AppointmentController::class, 'EditAppointment']);
    Route::post('/appointment/delete', [\App\Http\Controllers\AppointmentController::class, 'DeleteAppointment']);
    Route::get('/appointments/all', [\App\Http\Controllers\AppointmentController::class, 'getAllAppointments']);

    Route::get('/appointments/range', [\App\Http\Controllers\AppointmentController::class, 'getRangeAppointments']);

    Route::get('/appointments/statistique', [\App\Http\Controllers\AppointmentController::class, 'AppointmentStatistiqueInfo']);

    Route::post('/consultation/add', [\App\Http\Controllers\ConsultationController::class, 'AddConsultation'])->middleware('isdoctor');
    Route::post('/consultation/edit', [\App\Http\Controllers\ConsultationController::class, 'EditConsultation'])->middleware('isdoctor');
    Route::post('/consultation/delete', [\App\Http\Controllers\ConsultationController::class, 'DeleteConsultation'])->middleware('isdoctor');
    Route::get('/consultation/all', [\App\Http\Controllers\ConsultationController::class, 'getAllConsultations'])->middleware('isdoctor');
    Route::get('/consultation/{id}', [\App\Http\Controllers\ConsultationController::class, 'getConsultationDetail'])->middleware('isdoctor');


    Route::get('/medicines', [\App\Http\Controllers\MedicineController::class , 'index']);
    Route::post('/medicines/add', [\App\Http\Controllers\MedicineController::class , 'store']);
    Route::post('/medicines/update/{medicine}', [\App\Http\Controllers\MedicineController::class , 'update']);
    Route::post('/medicines/delete/{medicine}', [\App\Http\Controllers\MedicineController::class , 'delete']);

    Route::post('/prescription/add/{id}' , [\App\Http\Controllers\PrescriptionController::class , 'store'])->middleware('isdoctor');
    Route::get('/prescription/{id}' , [\App\Http\Controllers\PrescriptionController::class , 'show'])->middleware('isdoctor');

});




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

