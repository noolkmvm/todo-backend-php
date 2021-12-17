<?php

namespace App\Providers;

use App\Services\TodoListService;
use App\Services\TodoItemService;
use App\Contracts\ITodoListService;
use App\Contracts\ITodoItemService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ITodoListService::class, TodoListService::class);
        $this->app->bind(ITodoItemService::class, TodoItemService::class);
    }

    public function boot()
    {
        //
    }
}
