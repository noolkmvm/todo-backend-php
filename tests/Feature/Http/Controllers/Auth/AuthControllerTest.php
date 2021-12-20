<?php

namespace Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends TestCase
{
    public function testRegister()
    {
        $payload = [
            'username' => 'admin',
            'password' => '123456',
        ];

        $this->json('POST', 'api/auth/register', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['message']);
    }

    public function testLogin()
    {
        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
        ]);

        $this->json('POST', 'api/auth/login', ['username' => 'admin', 'password' => '123456'])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    public function testLoginBadRequest()
    {
        $this->json('POST', 'api/auth/login', ['username' => '36666', 'password' => '66663443'])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure(['error']);
    }

    public function testUser()
    {
        $this->actingAs($this->getUser())
            ->json('GET', 'api/auth/user')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['success']);
    }

    public function testLogout()
    {
        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('123456')
        ]);
        Auth::setTTL(config('jwt.ttl'))->attempt(['username' => 'admin', 'password' => '123456']);

        $this->actingAs($this->getUser())
            ->json('POST', 'api/auth/logout')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['message']);
    }

    public function testRefresh()
    {
        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make('123456')
        ]);
        Auth::setTTL(config('jwt.ttl'))->attempt(['username' => 'admin', 'password' => '123456']);

        $this->actingAs($this->getUser())
            ->json('POST', 'api/auth/refresh')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
