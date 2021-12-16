<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TodoList;
use Illuminate\Support\Arr;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoListPolicy
{
    use HandlesAuthorization;

    public function show(User $user, TodoList $todoList): bool
    {
        return $this->authorize($user, $todoList);
    }

    public function update(User $user, TodoList $todoList): bool
    {
        return $this->authorize($user, $todoList);
    }

    public function delete(User $user, TodoList $todoList): bool
    {
        return $this->authorize($user, $todoList);
    }

    private function authorize(User $user, TodoList $todoList): bool
    {
        $todoListUsersIds = $todoList->users()->select('user_id')->get()->toArray();

        $usersIds = [];
        foreach ($todoListUsersIds as $todoListUsersId) {
            $usersIds[] = Arr::first($todoListUsersId);
        }

        return in_array($user->id, $usersIds);
    }
}
