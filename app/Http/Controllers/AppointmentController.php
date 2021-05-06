<?php

namespace App\Http\Controllers;

use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AppointmentResource;
use Illuminate\Support\Facades\Validator;
use App\Models\appointment;

class AppointmentController extends Controller
{
    public function getAllAppointments(){
        $appointments = db::table('appointments')->get();
        return AppointmentResource::collection($appointments);
    }
    public function getRangeAppointments(Request $request){
        $start_time_range = $request->fromtime;
        $end_time_range = $request->totime;
        $start_date_range = $request->fromdate;
        $end_date_range = $request->todate;

        $date_range_appointment = db::table('appointments')
                                    ->whereBetween('date_appointment',[$start_date_range, $end_date_range])
                                    ->get();
        $ListAppointment = [];
        for($i = 0;$i < count($date_range_appointment);$i++){
            $start_time_appointment =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $date_range_appointment[$i]->start_time_appointment);
            $end_time_appointment =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $date_range_appointment[$i]->end_time_appointment);
            $start_time_range_loop =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $start_time_range);
            $end_time_range_loop =strtotime($date_range_appointment[$i]->date_appointment . ' ' . $end_time_range);

            if(($start_time_range_loop >= $start_time_appointment && $start_time_range_loop < $end_time_appointment)
                || ($end_time_range_loop > $start_time_appointment && $end_time_range_loop <= $end_time_appointment)){
                array_push($ListAppointment,$date_range_appointment[$i]);
            }
        }
        return $ListAppointment;
    }
    public function AddAppointment(Request $request){
        $validator = Validator::make($request->all(), [
            'patient_id'=> 'required',
            'date'=> 'required',
            'start_time'=> 'required',
            'end_time'=> 'required',
            'status'=> 'required',
        ]);
        if($validator->fails()){
            return false;
        }else{
            $appointment = new appointment();

            $appointment->patient_id = request('patient_id');
            $appointment->date_appointment = request('date');
            $appointment->start_time_appointment = request('start_time') . ':00';
            $appointment->end_time_appointment = request('end_time') . ':00';
            $appointment->state_appointment = request('status');

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
            'status'=> 'required',
            'confirme' => 'required',
        ]);
        $Appointment = appointment::where('id',$Validate['id']);
        $Appointment->update([
            'date_appointment' => $Validate['date'],
            'start_time_appointment' => $Validate['start_time'],
            'end_time_appointment' => $Validate['end_time'],
            'state_appointment' => $Validate['status'],
        ]);
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
