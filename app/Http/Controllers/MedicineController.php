<?php

namespace App\Http\Controllers;

use App\Models\medicine;
use App\Models\patient;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
            return medicine::orderBy('created_at', 'desc')->get()->map(function ($item) {
                $item['created_diff'] = $item->created_at->diffForHumans();
                return $item;
            });
    }
    public function store()
    {
        $medicine = request()->validate([
            'scientific_name' => ['required'],
            'trade_name' => ['required']
        ]);

        $created_medicine = medicine::create($medicine);
        if ($created_medicine){

            return response()->json($created_medicine , 200);
        }else{
            return [
                'error' => 'cannot create medicine'
            ];
        }
    }
    public function update(medicine $medicine)
    {
        $medicine_info = request()->validate([
            'scientific_name' => ['required'],
            'trade_name' => ['required']
        ]);

        $updated_medicine = $medicine->update($medicine_info);
        if ($updated_medicine){

            return response()->json([
                'message' => 'success'
            ] , 200);
        }else{
            return [
                'error' => 'cannot create medicine'
            ];
        }
    }

    public function delete(medicine $medicine)
    {
        $deleted_medicine = $medicine->delete();
        if ($deleted_medicine){
            return [
              'message' => 'success'
            ];
        }else{
            return [
                'error' => 'cannot delete medicine'
            ];
        }
    }


}
