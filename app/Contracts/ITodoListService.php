<?php

namespace App\Contracts;

use App\Models\TodoList;
use App\Http\Resources\TodoListResource;

interface ITodoListService
{
    public function create(array $params): TodoListResource;

    public function update(array $params, TodoList $todoList): TodoListResource;

    public function delete(TodoList $todoList): void;
}
