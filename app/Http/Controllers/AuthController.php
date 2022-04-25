<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
   function login(Request $request){
    $validator=Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if ($validator->fails()) {
        return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
    }

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['status'=>"error",'errors'=>["authError"=>['The provided credentials are incorrect.']]]);
    }
     $token=$user->createToken($request->email)->plainTextToken;

    return response()->json(['status'=>"success",'user'=>$user,'token'=>$token]);
   }
}
