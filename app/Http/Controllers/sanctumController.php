<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
class sanctumController extends Controller
{
    public function login(Request $request){
        $validate = Validator :: make(
            $request -> all(),[
            "email"=>"required|email",
            "password"=>"required",
            ]);
    
            
            if ($validate -> fails()){
              return response() -> json([
    
                'msg'=> 'datos invalidos',
                'error' => $validate->errors()
              ]);}
    
            $user = User::where("email",$request->email)->first();
            if(!$user || !Hash::check($request->get('password'), $user->password)){
                return response()->json([
                "msg" => "Datos incorrectos"
            
            ],401);}
               
            return response()->json([
                "msg" => "Logeado correctamente",
                "Token" => $user->createToken('acceso')->plainTextToken
            ]);
      }
}
