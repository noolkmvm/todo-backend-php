<?php

namespace Database\Seeders;

use App\Models\TodoList;
use App\Models\TodoItem;
use Illuminate\Database\Seeder;

class TodoItemSeeder extends Seeder
{
    private const ITEMS_COUNT = 5;

    public function run()
    {
        $todoLists = TodoList::all();

        foreach ($todoLists as $todoList) {
            for ($item = 0; $item < self::ITEMS_COUNT; $item++) {
                $todoItem = TodoItem::factory()->create();
                $todoList->items()->attach($todoItem);
            }
        }
    }
}
