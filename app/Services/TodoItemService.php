<?php

namespace App\Services;

use App\Models\TodoList;
use App\Models\TodoItem;
use App\Contracts\ITodoItemService;
use App\Http\Resources\TodoItemResource;

class TodoItemService implements ITodoItemService
{
    public function create(TodoList $todoList, array $params): TodoItemResource
    {
        $todoItem = TodoItem::create($params);
        $todoList->items()->attach($todoItem);

        return TodoItemResource::make($todoItem);
    }

    public function update(array $params, TodoItem $todoItem): TodoItemResource
    {
        $todoItem->update($params);

        return TodoItemResource::make($todoItem);
    }

    public function delete(TodoItem $todoItem): void
    {
        $todoItem->delete();
    }
}
