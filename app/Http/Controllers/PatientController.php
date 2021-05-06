<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function getAllPatient(){
        $patient = db::table('patients')->get();
        return PatientResource::collection($patient);
    }
}
