<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'date' => $this->date_appointment,
            'start' => $this->start_time_appointment,
            'end' => $this->end_time_appointment,
            'state' => $this->state_appointment,
            'type' => $this->type_appointment,
            'patient_id' => $this->patient_id,
            'patient_firstname' => $this->patient_firstname,
            'patient_lastname' => $this->patient_lastname,
            'patient_gender' => $this->gender,
            'patient_phone' => $this->phone,
            'patient_bloodType' => $this->bloodType,
            'patient_address' => $this->address,
            'image' => $this->patient_image,
            'consult' => $this->consult
        ];
    }
}
