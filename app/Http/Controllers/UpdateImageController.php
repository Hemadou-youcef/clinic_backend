<?php

namespace App\Http\Controllers;

use App\Models\patient;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UpdateImageController extends Controller
{
    public function store(patient $patient)
    {
        if (request()->hasFile('image')){
            request()->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',

            ]);
            $image = request()->file('image');
            $input['imagename'] = time().'.'.$patient->firstname.'-'.$patient->lastname.'.'.$image->extension();

            $destinationPath = public_path('/images/patients/');
            $img = Image::make($image->path());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$input['imagename']);
            $imageUrl = '/images/patients/'.$input['imagename'];
            $patient->image = $imageUrl;
            $patient->save();
            return [
                'imageUrl' => $imageUrl,
                'success' => 'ok'
            ];



        }
        return [
            'error' => 'cannot update image'
        ];
    }
}
