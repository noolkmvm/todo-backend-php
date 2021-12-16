<?php

namespace App\Http\Requests\TodoList;

use JetBrains\PhpStorm\ArrayShape;
use App\Http\Requests\ApiFormRequest;

class StoreTodoListRequest extends ApiFormRequest
{
    #[ArrayShape(['title' => "string", 'description' => "string"])] public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:255',
        ];
    }
}
