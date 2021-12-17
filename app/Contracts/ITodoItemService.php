<?php

namespace App\Contracts;

use App\Models\TodoItem;
use App\Models\TodoList;
use App\Http\Resources\TodoItemResource;

interface ITodoItemService
{
    public function create(TodoList $todoList, array $params): TodoItemResource;

    public function update(array $params, TodoItem $todoItem): TodoItemResource;

    public function delete(TodoItem $todoItem): void;
}
