<?php

namespace App\Providers;

use App\Services\TodoListService;
use App\Contracts\ITodoListService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ITodoListService::class, TodoListService::class);
    }

    public function boot()
    {
        //
    }
}
