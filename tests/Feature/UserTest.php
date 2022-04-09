<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $defaultStructResponseArr = [
        'data' => [
            '*' => [
                'id',
                'name',
                'email',
                'password',
                'created_at',
                'updated_at'
            ]
        ]
    ];

    private $defaultStructResponseShow = [
        'data' => [
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at'
        ]
    ];

    public function testIndexReturnsDataInValidFormat()
    {
        $this->actingAs()->json('get', 'api/users')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseArr
            );
    }

    public function testUserIsCreatedSuccessfully()
    {
        $payload = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => 12345
        ];

        $response = $this->json('post', 'api/users', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseShow
            )
            ->decodeResponseJson();

        //verifica se inseriu
        $this->assertTrue(User::find($response['data']['id']) != null);
    }

    public function testUserIsDestroyed()
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

        $response = $this->actingAs()->json('delete', "api/users/$user->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseShow
            )
            ->decodeResponseJson();

        //verifica se apagou
        $this->assertFalse(User::find($response['data']['id']) != null);
    }

    public function testUpdateUserReturnsCorrectData()
    {
        $user = User::create(
            [
                'name' => $this->faker->firstName,
                'email' => $this->faker->email,
                'password' => bcrypt('12345')
            ]
        );

        $payload = [
            'name' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => 12345
        ];

        $response = $this->actingAs()->json('put', "api/users/$user->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->decodeResponseJson();

        $responseArr = (array)$response['data'];
        unset($responseArr['id']);
        unset($responseArr['created_at']);
        unset($responseArr['updated_at']);

        $payload['password'] = '*****';

        //verifica se atualizou certo
        self::assertTrue($responseArr === $payload);
    }

    public function testDestroyForMissingUser()
    {
        $this->actingAs()->json('delete', 'api/users/0')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
