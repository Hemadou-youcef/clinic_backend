<?php

namespace App\Http\Controllers;

use App\Models\patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Intervention\Image\Image;

class PatientController extends Controller
{
    public function index()
    {

        $search_query = request()->query('q');

        if ($search_query){
            $result = patient::where('firstname', 'like', "%$search_query%")
                ->orWhere('lastname', 'like', "%$search_query%")
                ->orWhere('address', 'like', "%$search_query%")
                ->orWhere('bloodType', 'like', "%$search_query%")
                ->orWhere('email', 'like', "%$search_query%")
                ->orWhere('gender', $search_query)
                ->paginate(20);
            return $result;
        }
        if (request()->query('q')){}
//        return patient::all()->sortBy('updated_at',SORT_DESC)->toQuery()->paginate(20);
        return patient::all()->toQuery()->orderBy('created_at', 'desc')->paginate(20);
        $patients_list = patient::orderBy('created_at', 'DESC')->get();


        return $patients_list2;
    }

    public function store()
    {

        $patient_info = $this->validation(request());
        return patient::create($patient_info);
    }




    public function show($id )
    {
        if (request()->query('with_appointments')){
            $patient = patient::with('appointments')->find($id);

        }else{

            $patient = patient::find($id);
        }

        if ($patient) {
            return $patient;
        } else {
            return response()->json( ['error' => 'not found'] , 404);
        }

    }

    public function update(patient $patient)
    {
        $genders = ['male', 'female'];
        $bloodTypes = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        $patient_info = request()->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', Rule::in($genders)],
            'bloodType' => ['required', Rule::in($bloodTypes)],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'birthday' => ['required'],
            'phone' => ['required', 'min:5'], ]);
        if ($patient->update($patient_info)) {
            return ['status' => 'ok'];

        } else {
            return ['error' => 'not found'];
        }
    }

    public function destroy(patient $patient)
    {
        if ($patient->delete()) {
            return ['status' => 'ok'];
        } else {
            return ['error' => 'not found'];
        }
    }

    public function validation($request)
    {
        $genders = ['male', 'female'];
        $bloodTypes = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
        $request_info = request()->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', Rule::in($genders)],
            'bloodType' => ['required', Rule::in($bloodTypes)],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'birthday' => ['required'],
            'phone' => ['required', 'min:5'], ]);
        return $request_info;
    }

    public function search()
    {

    }

    public function getAllPatient(){
        $patient = patient::all();
        return PatientResource::collection($patient);
    }
}
