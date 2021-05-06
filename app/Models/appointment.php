<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\patient;

class appointment extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->hasOne(patient::class, 'foreign_key');
    }
}
