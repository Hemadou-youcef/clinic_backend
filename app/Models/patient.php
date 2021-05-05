<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patient extends Model
{
    use HasFactory;
    public $fillable = ['firstname' , 'lastname' , 'gender' , 'bloodType' , 'birthday' , 'address' , 'email' , 'phone' ];
//    public $guarded = [];
}
