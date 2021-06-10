<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class consultation extends Model
{
    use HasFactory;
    public $fillable = ['motive' , 'detail' , 'examination' , 'treatment' , 'type' , 'patient_id' , 'appointment_id'];

    public function patient()
    {
        return $this->belongsTo(patient::class );
    }
    public function appointment()
    {
        return $this->belongsTo(appointment::class );
    }
}
