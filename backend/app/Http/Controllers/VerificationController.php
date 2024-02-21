<?php
use App\Services\TelegramService;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function sendVerificationCode($chatId, $verificationCode)
    {
        $this->telegramService->sendVerificationCode($chatId, $verificationCode);
    }
}