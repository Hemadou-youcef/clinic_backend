<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;

    public function patient()
    {
       return $this->belongsTo(patient::class );
    }
    public function consultation()
    {
        return $this->hasOne(consultation::class , 'appointment_id');
    }
}
