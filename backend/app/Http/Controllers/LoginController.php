<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Services\TelegramService;
use App\Http\Requests\loginRequest;
use App\Http\Requests\uLoginRequest;
use App\Http\Requests\verifyRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\dRegisterRequest;
use App\Http\Requests\uRegisterRequest;
use App\Notifications\LoginVerification;

class LoginController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }
    public function userRegister(uRegisterRequest $request)
    {
        $validated = $request->validated();
        if ($request->phoneNumber[0] !=9 || strlen($request->phoneNumber) != 9) {
            return response()->json([
                "error" => "invalid phone number"
            ], 401);
        }
        if ($validated) {
            $user = User::create($validated);
        }
        return response()->json([
            "data" => $user,
            "access_token" => $user->createToken("api_token")->plainTextToken,
            "token_type" => "bearer"
        ]);
    }
    public function driverRegister(dRegisterRequest $request)
    {
        $validated = $request->validated();
        if ($request->phoneNumber[0] != 9  || strlen($request->phoneNumber) != 9) {
            return response()->json([
                "error" => "invalid phone number"
            ], 401);
        }
        if ($validated) {
            $userinfo = [];
            $userinfo['phoneNumber'] = $validated['phoneNumber'];
            unset($validated['phoneNumber']);
            $userinfo['name'] = $validated['name'];
            unset($validated['name']);
            $user = User::create($userinfo);
            $validated['user_id'] = $user->id;
            $driver = Driver::create($validated);
        }
        return response()->json([
            "data" => $driver,
            "access_token" => $user->createToken("api_token")->plainTextToken,
            "token_type" => "bearer"
        ]);
    }
    public function login(loginRequest $request)
    {
        $validated = $request->validated();
        if ($request->phoneNumber[0] != 9  || strlen($request->phoneNumber) != 9) {
            return response()->json([
                "error" => "invalid phone number"
            ], 401);
        }
        /* if(! Auth::attempt($validated)){
            return response()->json([
                "error"=> "unRegistered phone number"
            ],401);
        }*/
        $user = User::where("phoneNumber", $validated["phoneNumber"])->first();
        $verificationCode = rand(111111, 999999); // Generate your verification code

        $user->notify(new LoginVerification($verificationCode));

        return response()->json([
            "message" => "The login code has been sent to the phoneNumber"
        ]);
    }
    public function verify(verifyRequest $request)
    {
        $validated = $request->validated();
        if ($request->phoneNumber[0] != 9  || strlen($request->phoneNumber) != 9) {
            return response()->json([
                "error" => "invalid phone number"
            ], 401);
        }
        /* if(! Auth::attempt($validated)){
             return response()->json([
                 "error"=> "unRegistered phone number"
             ],401);
         }*/
        $user = User::where('phoneNumber', $validated['phoneNumber'])
            ->where('telegram_login_code', $validated['login_code'])
            ->first();

        if ($user) {
            $user->update(['telegram_login_code' => null]);

            return response()->json([
                'isDriver' => $user->isDriver,
                'access_token' => $user->createToken('api_token')->plainTextToken,
                'token_type' => 'bearer'
            ]);
        }

        return response()->json([
            'error' => 'Invalid login code'
        ], 401);
    }
}
