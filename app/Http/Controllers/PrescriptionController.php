<?php

namespace App\Http\Controllers;

use App\Models\consultation;
use App\Models\prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function store($id)
    {
        $consultation = consultation::find($id);
        if ($consultation) {
            $prescription = prescription::create();
            $consultation->prescription_id = $prescription->id;
            $consultation->save();
            $medicines = request()->all();
            foreach ($medicines as $med) {
                DB::table('medicine_prescription')->insert(
                    [
                        'prescription_id' => $prescription->id,
                        'medicines_id' => intval($med['id']),
                        'dose' => $med['dose']
                    ]);
            }
            return response( ['message' => 'success'] , 200);
        } else {
            return  response( ['message' => 'error'] , 404);
        }


    }

    public function show($id)
    {
        $prescription = prescription::find($id);
        return $prescription->medicines;
    }


}
