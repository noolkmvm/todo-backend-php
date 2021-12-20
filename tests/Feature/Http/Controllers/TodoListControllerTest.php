<?php

namespace Http\Controllers;

use Tests\TestCase;
use App\Models\TodoList;
use Symfony\Component\HttpFoundation\Response;

class TodoListControllerTest extends TestCase
{
    public function testIndexReturnsDataInValidFormat()
    {
        $todoList = TodoList::factory()->create();
        $this->getUser()->lists()->attach($todoList);

        $this->actingAs($this->getUser())
            ->json('GET', 'api/lists')
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

    public function testListIsStoredSuccessfully()
    {
        $payload = [
            'title' => 'test',
            'description' => 'test test test',
        ];

        $this->actingAs($this->getUser())
            ->json('POST', 'api/lists', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id', 'title', 'description']);

        $this->assertDatabaseHas('todo_lists', $payload);
    }

    public function testStoreWithMissingData()
    {
        $payload = [
            //missing data
        ];

        $this->actingAs($this->getUser())
            ->json('POST', 'api/lists', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors']);
    }

    public function testListIsShownCorrectly()
    {
        /** @var TodoList $todoList */
        $todoList = TodoList::factory()->create();
        $this->getUser()->lists()->attach($todoList);

        $this->actingAs($this->getUser())
            ->json('GET', "api/lists/$todoList->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'id' => $todoList->id,
                'title' => $todoList->title,
                'description' => $todoList->description,
            ]);
    }

    public function testShowForMissingList()
    {
        $this->actingAs($this->getUser())
            ->json('GET', "api/lists/0")
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['message']);
    }

    public function testListIsDestroyed()
    {
        $todoListData = [
            'title' => 'test',
            'description' => 'test test test',
        ];
        $todoList = TodoList::create($todoListData);
        $this->getUser()->lists()->attach($todoList);

        $this->actingAs($this->getUser())
            ->json('DELETE', "api/lists/$todoList->id")
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', $todoListData);
    }

    public function testDestroyForMissingList()
    {
        $this->actingAs($this->getUser())
            ->json('DELETE', 'api/lists/0')
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['message']);
    }
}
