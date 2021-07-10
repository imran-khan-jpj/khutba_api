<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function __construct(){
        $this->middleware('auth:sanctum');
    }
    public function resetPassword(Request $request){
        $data = $request->validate([
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6|different:old_password',
        ]);

        // return $data;
        
        if (Hash::check($request->old_password, auth()->user()->password)) { 
           auth()->user()->fill([
            'password' => Hash::make($request->password)
            ])->save();
        
            return response()->json(['success' => 'Password Changed Successfully'], 200);
        
        } else {
            return response()->json(['err' => 'Something went wrong pleaset try again'], 403);
        }



    }
}
