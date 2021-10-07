<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Str;
use Illuminate\Support\Facades\Validator;
class BaseController extends Controller
{
    //
    public function index(){
        return ['message','Base Controller'];
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
           'name'=>'required',
           'email'=>'required|unique:users',
           'password'=>'required',
           'c_password'=>'required|same:password',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),202);
        }
        $input=$request->all();
        $input['password']=bcrypt($input['password']);
        $user=User::create($input);
       $token = $user->createToken('Laravel Password Grant Client')->accessToken;
       $response = ['token' => $token];

        return response($response,'201');
    }
    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $token = $user->createToken('my-app-token')->accessToken;

            $response = ['token' => $token,
              'name'=>$user->name];
            if ($user->user_type==1){
                return ['admin',$response];

            }
            else{


            return response($response,200);
            }


        }else{
            return response()->json(['error'=>'Unauthenticated'],203);
        }
    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message','logout ']);
    }

}
