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
//    Route::get('/patients' , [\App\Http\Controllers\PatientController::class , 'index']);
    Route::get('/patient/{id}', [\App\Http\Controllers\PatientController::class, 'show']);
    Route::post('/patient/create', [\App\Http\Controllers\PatientController::class, 'store']);
    Route::post('/patient/delete/{patient}', [\App\Http\Controllers\PatientController::class, 'destroy']);
    Route::post('/patient/update/{patient}', [\App\Http\Controllers\PatientController::class, 'update']);
});




Route::get('/password' , function (){

    return \Illuminate\Support\Facades\Hash::make('samisamo');
});


