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
        $colorAppointment = '';
        if($this->state_appointment == 'consult'){
            $colorAppointment = 'green';
        }else {
            $colorAppointment = 'primary';
        }
        return [
            'id' => $this->id,
            'date' => $this->date_appointment,
            'start' => $this->start_time_appointment,
            'end' => $this->end_time_appointment,
            'state' => $this->state_appointment,
            'color' => $colorAppointment,
            'patient_id' => $this->patient_id,
        ];
    }
}
