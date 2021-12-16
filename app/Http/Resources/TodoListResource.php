<?php

namespace App\Http\Resources;

use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoListResource extends JsonResource
{
    #[ArrayShape(['id' => "int", 'title' => "string", 'description' => "string"])] public function toArray($request
    ): array {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
        ];
    }
}
