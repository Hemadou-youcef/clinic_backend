<?php

namespace App\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $credentials =  request()->validate([
            'username' => ['required' , 'min:4'],
            'password' => ['required' , 'min:8']
        ]);

        if ( Auth::attempt($credentials)){
            return response()->json(Auth::user(), 200);
        }

         throw \Illuminate\Validation\ValidationException::withMessages([
            'UserNotFound' => 'user not found'
        ]);

    }

    public function logout()
    {
        if (Auth::check()){
            Auth::logout();
        }
    }
}
