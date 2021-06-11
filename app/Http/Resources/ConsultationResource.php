<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'PatientFullName' => $this->patient_firstname . ' ' . $this->patient_lastname,
            'PatientImage' => $this->patient_image,
            'PatientID' => $this->patient_id,
            'motive' => $this->motive,
            'date' => $this->appointment_date,
            'time' => substr($this->appointment_time,0,5),
            'consultation_date' => $this->created_at
        ];
    }
}

//return consultation::orderBy($order_by_column, $order_by_type)->get()->map(function ($item) {
//    $patient = patient::find($item->patient_id);
//    $item['PatientFullName'] =$patient->firstname . ' ' .$patient->lastname;
//    $item['PatientImage'] =$patient->image;
//    $item['PatientID'] =$patient->id;
//    $item['consultation_date'] =$item->created_at;
//    $appointment = appointment::find($item->appointment_id);
//    $item['date'] = $appointment->date_appointment ;
//    $item['time'] = substr( $appointment->start_time_appointment,0,5);
//    return $item;
//})->toQuery()->paginate(20);
