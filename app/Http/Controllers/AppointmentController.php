<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\patient;
use App\Http\Resources\AppointmentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\appointment;

class AppointmentController extends Controller
{
    public function getAllAppointments(){

        $appointments = appointment::all()->map(function ($item) {
            $patient = patient::find($item->patient_id);
            $item['patient_firstname'] = $patient->firstname;
            $item['patient_lastname'] = $patient->lastname;
            $item['gender'] = $patient->gender;
            $item['patient_image'] = $patient->image;
            return $item;
        });
        return AppointmentResource::collection($appointments);


    }
    public function getRangeAppointments(Request $request){
        $start_time_range = $request->fromtime;
        $end_time_range = $request->totime;
        $start_date_range = $request->fromdate;
        $end_date_range = $request->todate;


        $date_range_appointment = appointment::whereBetween('date_appointment',[$start_date_range, $end_date_range])
            ->get()
            ->map(function ($item) {
            $patient = patient::find($item->patient_id);
            $item['patient_firstname'] = $patient->firstname;
            $item['patient_lastname'] = $patient->lastname;
            $item['gender'] = $patient->gender;
            $item['phone'] = $patient->phone;
            $item['bloodType'] = $patient->bloodType;
            $item['address'] = $patient->address;
            $item['patient_image'] = $patient->image;
            return $item;
        });
        $ListAppointment = [];
        for($i = 0;$i < count($date_range_appointment);$i++){
            $start_time_appointment =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $date_range_appointment[$i]->start_time_appointment);
            $end_time_appointment =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $date_range_appointment[$i]->end_time_appointment);

            $start_time_range_loop =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $start_time_range);
            $end_time_range_loop =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $end_time_range);


            if(($start_time_range_loop <= $start_time_appointment && $end_time_range_loop > $start_time_appointment)
                || ($start_time_range_loop < $end_time_appointment && $end_time_range_loop >= $end_time_appointment)){
                array_push($ListAppointment,$date_range_appointment[$i]);
            }
        }
        return AppointmentResource::collection($ListAppointment);
    }
    public function AddAppointment(Request $request){
        $validator = Validator::make($request->all(), [
            'patient_id'=> 'required',
            'date'=> 'required',
            'start_time'=> 'required',
            'end_time'=> 'required',
            'type'=> 'required',
        ]);
        if($validator->fails()){
            return false;
        }else{
            $appointment = new appointment();

            $appointment->patient_id = request('patient_id');
            $appointment->date_appointment = request('date');
            $appointment->start_time_appointment = request('start_time') . ':00';
            $appointment->end_time_appointment = request('end_time') . ':00';
            $appointment->type_appointment = request('type');
            $appointment->state_appointment = 'waiting';

            $appointment->save();

            $Response = [
                'message' => 'success',
            ];
            return response($Response,201);

        }

    }
    public function EditAppointment(Request $request){
        $Validate = $request->validate([
            'id' => 'required',
            'patient_id'=> 'required',
            'date'=> 'required',
            'start_time'=> 'required',
            'end_time'=> 'required',
            'type'=> 'required',
            'state'=> 'required',
            'confirme' => 'required',
        ]);
        $Appointment = appointment::where('id',$Validate['id']);
        $state = $Validate['state'];
        if($state == 'fix'){
            $Appointment->update([
                'date_appointment' => $Validate['date'],
                'start_time_appointment' => $Validate['start_time'],
                'end_time_appointment' => $Validate['end_time'],
                'type_appointment' => $Validate['type'],
            ]);
        }else{
            $Appointment->update([
                'state_appointment' => $state,
            ]);
        }

        $Response = [
            'message' => 'success',
        ];
        return response($Response,201);
    }
    public function DeleteAppointment(Request $request){
        $Validate = $request->validate([
            'id' => 'required',
            'confirme' => 'required',
        ]);
        $Appointment = appointment::where('id',$Validate['id'])->get()->first();
        if(!$Appointment || $Validate['confirme'] != 'yes'){
            return response(['message' => 'error',],204);
        }
        $Appointment->delete();
        $Response = [
            'message' => 'success',
        ];
        return response($Response,200);
    }
}
