<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private Generator $faker;

    public function setUp(): void
    {

        parent::setUp();
        $this->faker = Factory::create();
        DB::beginTransaction();
    }

    public function tearDown(): void
    {
        DB::rollBack();
    }

    public function __get($key)
    {

        if ($key === 'faker')
            return $this->faker;
        throw new Exception('Unknown Key Requested');
    }

    public function actingAs($user = null, $driver = 'api')
    {
        $userData =
            [
                'name' => $this->faker->firstName,
                'email' => $this->faker->email,
                'password' => bcrypt('12345')
            ];

        $user = User::create(
            $userData
        );

        $user = ['email' => (array) $user->email, 'password' => 12345];

        $token = JWTAuth::attempt($user);
        $this->withHeader('Authorization', "Bearer {$token}");
        return $this;
    }
}
