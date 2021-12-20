<?php

namespace Database\Factories;

use App\Models\TodoItem;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoItemFactory extends Factory
{
    protected $model = TodoItem::class;

    #[ArrayShape(['title' => "string", 'description' => "string"])] public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
        ];
    }
}
