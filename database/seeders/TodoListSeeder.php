<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Database\Seeder;

class TodoListSeeder extends Seeder
{
    private const LISTS_COUNT = 5;

    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            for ($list = 0; $list < self::LISTS_COUNT; $list++) {
                $todoList = TodoList::factory()->create();
                $user->lists()->attach($todoList);
            }
        }
    }
}
