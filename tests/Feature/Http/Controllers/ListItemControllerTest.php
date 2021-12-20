<?php

namespace Http\Controllers;

use Tests\TestCase;
use App\Models\TodoList;
use App\Models\TodoItem;
use Symfony\Component\HttpFoundation\Response;

class ListItemControllerTest extends TestCase
{
    public function testIndexReturnsDataInValidFormat()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);
        $todoItem = TodoItem::factory()->create();
        $todoList->items()->attach($todoItem);

        $this->actingAs($this->getUser())
            ->json('GET', "api/lists/$todoList->id/items")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'title',
                        'description',
                    ]
                ]
            );
    }

    public function testItemIsStoredSuccessfully()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);
        $payload = [
            'title' => 'test',
            'description' => 'test test test',
        ];

        $this->actingAs($this->getUser())
            ->json('POST', "api/lists/$todoList->id/items", $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id', 'title', 'description']);

        $this->assertDatabaseHas('todo_items', $payload);
    }

    public function testStoreWithMissingData()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);
        $payload = [
            //missing data
        ];

        $this->actingAs($this->getUser())
            ->json('POST', "api/lists/$todoList->id/items", $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors']);
    }

    public function testItemIsShownCorrectly()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);
        /** @var TodoItem $todoItem */
        $todoItem = TodoItem::factory()->create();
        $todoList->items()->attach($todoItem);

        $this->actingAs($this->getUser())
            ->json('GET', "api/lists/$todoList->id/items/$todoItem->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'id' => $todoItem->id,
                'title' => $todoItem->title,
                'description' => $todoItem->description,
            ]);
    }

    public function testShowForMissingItem()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);

        $this->actingAs($this->getUser())
            ->json('GET', "api/lists/$todoList->id/items/1")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['message']);
    }

    public function testItemIsDestroyed()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);
        $todoItemData = [
            'title' => 'test',
            'description' => 'test test test',
        ];
        $todoItem = TodoItem::create($todoItemData);
        $todoList->items()->attach($todoItem);

        $this->actingAs($this->getUser())
            ->json('DELETE', "api/lists/$todoList->id/items/$todoItem->id")
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_items', $todoItemData);
    }

    public function testDestroyForMissingItem()
    {
        $todoList = TodoList::create(TodoList::factory()->raw());
        $this->getUser()->lists()->attach($todoList);

        $this->actingAs($this->getUser())
            ->json('DELETE', "api/lists/$todoList->id/items/1")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['message']);
    }
}
