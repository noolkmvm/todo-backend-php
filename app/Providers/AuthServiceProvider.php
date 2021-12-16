<?php

namespace App\Providers;

use App\Models\TodoList;
use App\Policies\TodoListPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        TodoList::class => TodoListPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
