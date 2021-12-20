<?php

namespace Tests;

use Exception;
use Faker\Factory;
use Faker\Generator;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:refresh');
        User::factory()->create()->first();
    }

    /**
     * @throws Exception
     */
    public function __get($key)
    {
        if ($key === 'faker') {
            return $this->faker;
        }
        throw new Exception('Unknown Key Requested');
    }

    protected function getUser(): User
    {
        return User::all()->random(1)->first();
    }
}
