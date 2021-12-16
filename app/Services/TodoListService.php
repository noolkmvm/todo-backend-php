<?php

namespace App\Services;

use App\Models\TodoList;
use App\Contracts\ITodoListService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TodoListResource;

class TodoListService implements ITodoListService
{
    public function create(array $params): TodoListResource
    {
        $todoList = TodoList::create($params);
        Auth::user()->lists()->attach($todoList);

        return TodoListResource::make($todoList);
    }

    public function update(array $params, TodoList $todoList): TodoListResource
    {
        $todoList->update($params);

        return TodoListResource::make($todoList);
    }

    public function delete(TodoList $todoList): void
    {
        $todoList->delete();
    }
}
