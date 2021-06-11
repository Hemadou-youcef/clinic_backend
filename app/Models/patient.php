<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;
    public $fillable = ['firstname' , 'lastname' , 'gender' , 'bloodType' , 'birthday' , 'address' , 'email' , 'phone' , 'image'];
//    public $guarded = [];

    public function appointments ()
    {
            return $this->hasMany(appointment::class , 'patient_id');
    }
    public function consultations ()
    {
        return $this->hasMany(consultation::class , 'patient_id');
    }
}
