<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use App\Notifications\loginVerification;
use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;
use App\Http\Requests\uLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\dRegisterRequest;
use App\Http\Requests\uRegisterRequest;

class LoginController extends Controller
{
    public function userRegister(uRegisterRequest $request){
        $validated= $request->validated();
        if($request->phoneNumber[0]!=0 || $request->phoneNumber[1]!=9 || strlen($request->phoneNumber)!= 10){
            return response()->json([
                "error"=> "invalid phone number"
            ],401);
        }
        if($validated){
            $user=User::create($validated);
        }
        return response()->json([
            "data"=>$user,
            "access_token"=> $user->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
    public function driverRegister(dRegisterRequest $request){
        $validated= $request->validated();
        if($request->phoneNumber[0]!=0 || $request->phoneNumber[1]!=9 || strlen($request->phoneNumber)!= 10){
            return response()->json([
                "error"=> "invalid phone number"
            ],401);
        }
        if($validated){
            $userinfo=[];
            $userinfo['phoneNumber']=$validated['phoneNumber'];
            unset($validated['phoneNumber']);
            $userinfo['name']=$validated['name'];
            unset($validated['name']);
            $user=User::create($userinfo);
            $validated['user_id']=$user->id;
            $driver=Driver::create($validated);
        }
        return response()->json([
            "data"=>$driver,
            "access_token"=> $user->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
    public function login(loginRequest $request){
        $validated= $request->validated();
        if(! Auth::attempt($validated)){
            return response()->json([
                "error"=> "invalid phone number"
            ],401);
        }
        $user=User::where("phoneNumber", $validated["phoneNumber"])->first();
        $user->notify(); 
        return response()->json([
            "isDriver"=>$user->isDriver,
            "access_token"=> $user->createToken("api_token")->plainTextToken,
            "token_type"=>"bearer"
        ]);
    }
}
