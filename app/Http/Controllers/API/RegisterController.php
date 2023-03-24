<?php

namespace App\Http\Controllers\API;




use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller

{
   
  

    public function register(Request $request)
    {
        $validator = $request->validate([
            'First_name' => 'required',
            'Last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
          
            ]);

        $user = User::create([
        'First_name' => $validator['First_name'],
        'Last_name' => $validator['Last_name'],
        'email' => $validator['email'],
        'password'=>bcrypt($validator['password']),
    
            ]);

$token = $user->createToken('myToken')->plainTextToken;
   $response = [
    
    'user'=>$user,
    'myToken'=>$token,
   
   ];

   return response($response,200);
   
    }

    public function login(Request $request)
    {
        $validator = $request->validate([
           
            'email' => 'required|string',
            'password' => 'required',
          
            ]);

      $user = User::where('email',$validator['email'])->first();
      $usepass=  Hash::check($validator['password'],$user->password);
      if(!$user || !$usepass){

        return response(["message"=>"bad login"],401);
      }

$token = $user->createToken('myToken')->plainTextToken;
   $response = [
    
    'user'=>$user,
    'myToken'=>$token,
   
   ];

   return response($response,200);
   
    }













    public function logout(){
        auth()->user()->tokens()->delete();

        return ["message"=>"logout"];
    }

 
     
}