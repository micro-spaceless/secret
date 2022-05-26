<?php

namespace MicroSpaceless\Hack\Providers;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
    public function register()
    {
    }
}
