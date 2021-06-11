<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
    use HasFactory;

    public function medicines()
    {
        return $this->belongsToMany(medicine::class, 'medicine_prescription' , 'prescription_id' ,'medicines_id' )->withPivot('dose');
    }
}
