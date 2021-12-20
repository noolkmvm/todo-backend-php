<?php

namespace Database\Factories;

use App\Models\TodoList;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoListFactory extends Factory
{
    protected $model = TodoList::class;

    #[ArrayShape(['title' => "string", 'description' => "string"])] public function definition(): array
    {
        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
        ];
    }
}
