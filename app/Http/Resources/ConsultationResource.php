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
        ];
    }
}
