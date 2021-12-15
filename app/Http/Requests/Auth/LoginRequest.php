<?php

namespace App\Http\Requests\Auth;

use JetBrains\PhpStorm\ArrayShape;
use App\Http\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest
{
    #[ArrayShape(['username' => "string", 'password' => "string"])] public function rules(): array
    {
        return [
            'username' => 'required|string|min:4|max:26',
            'password' => 'required|string|min:6',
        ];
    }
}
