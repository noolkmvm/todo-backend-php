<?php

namespace App\Http\Requests\TodoItem;

use JetBrains\PhpStorm\ArrayShape;
use App\Http\Requests\ApiFormRequest;

class UpdateTodoItemRequest extends ApiFormRequest
{
    #[ArrayShape(['title' => "string", 'description' => "string", 'done' => "boolean"])] public function rules(): array
    {
        return [
            'title' => 'string|min:3|max:255',
            'description' => 'string|min:3|max:255',
            'done' => 'boolean',
        ];
    }
}
