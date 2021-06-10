<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsultationResource;
use App\Models\appointment;
use App\Models\consultation;
use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationController extends Controller
{
    public function getAllConsultations(){

        $consultations = consultation::all()->map(function ($item) {
            $patient = patient::find($item->patient_id);
            $item['patient_firstname'] = $patient->firstname;
            $item['patient_lastname'] = $patient->lastname;
            $item['patient_id'] = $patient->id;
            $item['patient_image'] = $patient->image;
            $appointment = appointment::find($item->appointment_id);
            $item['appointment_date'] = $appointment->date_appointment ;
            $item['appointment_time'] = $appointment->start_time_appointment;
            return $item;
        });
        return ConsultationResource::collection($consultations);


    }
    public function getConsultationDetail($id){

//        $consultations = consultation::all()->where('id',$id)->map(function ($item) {
//            $patient = patient::find($item->patient_id);
//            $item['patient_firstname'] = $patient->firstname;
//            $item['patient_lastname'] = $patient->lastname;
//            $item['patient_id'] = $patient->id;
//            $item['patient_image'] = $patient->image;
//            $appointment = appointment::find($item->appointment_id);
//            $item['appointment_date'] = $appointment->date_appointment ;
//            $item['appointment_time'] = $appointment->start_time_appointment;
//            return $item;
//        });
        $consultations = consultation::with('appointment')->with('patient')->find($id);
        if(isset($consultations) == 0)
            return response('not found',404);
        else
            return $consultations;
    }
    public function AddConsultation(Request $request){

        $validator = Validator::make($request->all(), [
            'Reason'=> 'required',
            'Detail'=> 'required',
            'Examination'=> 'required',
            'Treatment'=> 'required',
            'Type'=> 'required',
            'idPatient'=> 'required',
        ]);
        if($validator->fails()){
            return false;
        }else{

            $consultation = new consultation();

            $consultation->motive = request('Reason');
            $consultation->detail = request('Detail');
            $consultation->examination = request('Examination');
            $consultation->treatment  = request('Treatment');
            $consultation->type = request('Type');
            $consultation->patient_id = request('idPatient');
            $consultation->appointment_id = request('idAppointment');

            $consultation->save();
            $Response = [
                'message' => 'success',
            ];
            return response($Response,201);

        }
    }
    public function EditConsultation(Request $request){
        $Validate = $request->validate([
            'id' => 'required',
            'Reason'=> 'required',
            'Detail'=> 'required',
            'Examination'=> 'required',
            'Treatment'=> 'required',
            'Type'=> 'required',
        ]);
        $Consultation = consultation::where('id',$Validate['id']);
        $Consultation->update([
            'motive' => $Validate['Reason'],
            'detail' => $Validate['Detail'],
            'examination' => $Validate['Examination'],
            'treatment' => $Validate['Treatment'],
            'type' => $Validate['Type'],
        ]);

        $Response = [
            'message' => 'success',
        ];
        return response($Response,201);
    }
    public function DeleteConsultation(Request $request){
        $Validate = $request->validate([
            'id' => 'required'
        ]);
        $Consultation = consultation::where('id',$Validate['id'])->get()->first();
        if(!$Consultation){
            return response(['message' => 'error',],204);
        }
        $Consultation->delete();
        $Response = ['message' => 'success',];
        return response($Response,200);
    }
}
