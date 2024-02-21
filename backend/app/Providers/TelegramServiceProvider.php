<?php

namespace App\Providers;

use App\Services\TelegramService;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TelegramService::class, function ($app) {
            $telegram = new Api(config('app.telegram_bot_token'));
            return new TelegramService($telegram);
        });
    }
}