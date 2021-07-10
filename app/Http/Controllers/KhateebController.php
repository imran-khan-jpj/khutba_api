<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KhateebController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['khateebs'=> User::where('role', 'khateeb')->get()], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => "required|string|min:3",
            'email' => "required|email|unique:users",
            'password' => "required|min:6|confirmed",
        ]);
        $data['role'] = 'khateeb';
        $data['religion'] = 'muslim';
        $data['password'] = Hash::make($data['password']);
        
        if($user = User::create($data)){
            return response()->json(['user' => $user], 200);
        }else{
            return response()->json(['err' => 'something went wrong please try Again'], 403);
        }
    }

    public function destroy(User $user){
        if($user->delete()){

            return response()->json(['success'=> 'success'], 200);
        }else{
            return response()->json(['err'=> 'error'], 403);

        }
    }

}
