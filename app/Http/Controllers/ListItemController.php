<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\TodoList;
use App\Models\TodoItem;
use Illuminate\Http\JsonResponse;
use App\Contracts\ITodoItemService;
use App\Http\Resources\TodoItemResource;
use App\Http\Requests\TodoItem\StoreTodoItemRequest;
use App\Http\Requests\TodoItem\UpdateTodoItemRequest;

class ListItemController extends Controller
{
    public function __construct(private ITodoItemService $todoItemService)
    {
    }

    public function index(TodoList $list): JsonResponse
    {
        try {
            $this->authorize('index', $list);
            $todoItems = TodoItemResource::collection($list->items()->getModels());
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess($todoItems);
    }

    public function store(TodoList $list, StoreTodoItemRequest $request): JsonResponse
    {
        try {
            $this->authorize('store', $list);
            $todoItem = $this->todoItemService->create($list, $request->all());
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondCreated($todoItem);
    }

    public function show(TodoList $list, TodoItem $item): JsonResponse
    {
        try {
            $this->authorize('show', $list);
            $todoItem = TodoItemResource::make($item);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess($todoItem);
    }

    public function update(TodoList $list, UpdateTodoItemRequest $request, TodoItem $item): JsonResponse
    {
        try {
            $this->authorize('update', $list);
            $todoItem = $this->todoItemService->update($request->all(), $item);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess($todoItem);
    }

    public function destroy(TodoList $list, TodoItem $item): JsonResponse
    {
        try {
            $this->authorize('delete', $list);
            $this->todoItemService->delete($item);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondNoContent();
    }
}
