<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\TodoList;
use Illuminate\Http\JsonResponse;
use App\Contracts\ITodoListService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TodoListResource;
use App\Http\Requests\TodoList\StoreTodoListRequest;
use App\Http\Requests\TodoList\UpdateTodoListRequest;

class TodoListController extends Controller
{
    public function __construct(private ITodoListService $todoListService)
    {
    }

    public function index(): JsonResponse
    {
        $todoLists = TodoListResource::collection(Auth::user()->lists()->get());

        return $this->respondWithSuccess($todoLists);
    }

    public function store(StoreTodoListRequest $request): JsonResponse
    {
        $todoList = $this->todoListService->create($request->all());

        return $this->respondCreated($todoList);
    }

    public function show(TodoList $todoList): JsonResponse
    {
        try {
            $this->authorize('show', $todoList);
            $todoList = TodoListResource::make($todoList);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess($todoList);
    }

    public function update(UpdateTodoListRequest $request, TodoList $todoList): JsonResponse
    {
        try {
            $this->authorize('update', $todoList);
            $todoList = $this->todoListService->update($request->all(), $todoList);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithSuccess($todoList);
    }

    public function destroy(TodoList $todoList): JsonResponse
    {
        try {
            $this->authorize('delete', $todoList);
            $this->todoListService->delete($todoList);
        } catch (Throwable $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondNoContent();
    }
}
