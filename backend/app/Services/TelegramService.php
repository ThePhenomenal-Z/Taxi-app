<?php

namespace App\Services;
use App\Models\User;
use Telegram\Bot\Api;
use Illuminate\Http\Request;
use App\Notifications\LoginVerification;

class TelegramService
{
    protected $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function sendVerificationCode(Request $request)
    {
        // Validate the request data
    
        $validated = $request->validate([
            'phoneNumber' => 'required'
        ]);
    
        // Find the user based on the phone number
        $user = User::where("phoneNumber", $validated["phoneNumber"])->first();
    
        if (!is_null($user)) {
            // Generate the verification code
            $verificationCode = rand(111111,999999); // Replace with your code to generate the verification code
    
                   // Save the telegram_chat_id to the user (assuming you have added the field to the User model)
        $user->telegram_chat_id = $request->telegram_chat_id;
        $user->save();

        // Send the notification
        $notification = new LoginVerification($verificationCode);
        $user->notify($notification);

        return response()->json([
            "message" => "The login code has been sent to the phoneNumber"
        ]);
    } else {
        // User not found
        return response()->json([
            "message" => "User not found"
        ], 404);
    }
    }
}