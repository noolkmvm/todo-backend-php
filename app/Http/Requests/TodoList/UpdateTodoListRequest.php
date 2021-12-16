<?php

namespace App\Http\Requests\TodoList;

use JetBrains\PhpStorm\ArrayShape;
use App\Http\Requests\ApiFormRequest;

class UpdateTodoListRequest extends ApiFormRequest
{
    #[ArrayShape(['title' => "string", 'description' => "string"])] public function rules(): array
    {
        return [
            'title' => 'string|min:3|max:255',
            'description' => 'string|min:3|max:255',
        ];
    }
}
