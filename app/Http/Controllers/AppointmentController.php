<?php

namespace App\Http\Controllers;

use App\Models\consultation;
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
            if ($item->consultation){
                $item['has_consultation'] = 'true';
                $consultation = consultation::where('appointment_id',$item['id'])->get()->first();
                $item['consult'] = $consultation->id;
            }else{
                $item['has_consultation'] = 'false';
            }
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
                if ($item->consultation){
                    $item['has_consultation'] = 'true';
                    $consultation = consultation::where('appointment_id',$item['id'])->get()->first();
                    $item['consult'] = $consultation->id;
                }else{
                    $item['has_consultation'] = 'false';
                }
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
            return response(['message' => 'validation failed'] , 404);
        }else{
            $appointment = new appointment();
            $appointment->patient_id = request('patient_id');
            $appointment->date_appointment = request('date');
            $appointment->start_time_appointment = request('start_time') . ':00';
            $appointment->end_time_appointment = request('end_time') . ':00';
            $appointment->type_appointment = request('type');
            $appointment->state_appointment = 'waiting';
            $appointment->save();
            return response([
                'message' => 'success',
            ],201);

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
            if($Appointment->get()->first()->state_appointment != 'missed'){
                $Appointment->update([
                    'state_appointment' => $state,
                ]);
            }
        }

        $Response = [
            'message' => 'success',
        ];
        return response($Response,201);
    }
    public function DeleteAppointment(Request $request){
        $Validate = $request->validate(['id' => 'required',]);
        $Appointment = appointment::where('id',$Validate['id'])->get()->first();
        if(!$Appointment){
            return response(['message' => 'error',],404);
        }
        $Appointment->delete();
        $Response = ['message' => 'success'];
        return response($Response,200);
    }
    public function AppointmentStatistiqueInfo(Request $request){
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
        $filtredListAppointment = [];
        if($request->type == 'gender'){
            for($i = 0;$i < count($ListAppointment);$i++){
                array_push($filtredListAppointment,[
                        'gender' => $ListAppointment[$i]->gender,
                        'date' =>  $ListAppointment[$i]->date_appointment
                    ]
                );
            }
        }else if($request->type == 'blood'){
            for($i = 0;$i < count($ListAppointment);$i++){
                array_push($filtredListAppointment,[
                        'blood' => $ListAppointment[$i]->bloodType,
                        'date' =>  $ListAppointment[$i]->date_appointment
                    ]
                );
            }
        }else if($request->type == 'state'){
            for($i = 0;$i < count($ListAppointment);$i++){
                if($ListAppointment[$i]->state_appointment == 'missed'
                    || $ListAppointment[$i]->state_appointment == 'check'){
                    array_push($filtredListAppointment,[
                            'state' => $ListAppointment[$i]->state_appointment,
                            'date' =>  $ListAppointment[$i]->date_appointment
                        ]
                    );
                }
            }
        }else if($request->type == 'type'){
            for($i = 0;$i < count($ListAppointment);$i++){
                array_push($filtredListAppointment,[
                        'type' => $ListAppointment[$i]->type_appointment,
                        'date' =>  $ListAppointment[$i]->date_appointment
                    ]
                );
            }
        }
        return $filtredListAppointment;
//        return $ListAppointment;
    }
}
