<?php

namespace Tests\Feature;

use App\Models\Eletrodomestico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class EletrodomesticoTest extends TestCase
{
    private $defaultStructResponseArr = [
        'data' => [
            '*' => [
                'id',
                'descricao',
                'marca_id',
                'marca',
                'created_at',
                'updated_at'
            ]
        ]
    ];

    private $defaultStructResponseShow = [
        'data' => [
            'id',
            'descricao',
            'marca_id',
            'marca',
            'created_at',
            'updated_at'
        ]
    ];

    public function testIndexReturnsDataInValidFormat()
    {
        $this->actingAs()->json('get', 'api/appliances')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseArr
            );
    }

    public function testApplianceIsCreatedSuccessfully()
    {
        $payload = [
            'descricao' => $this->faker->name . ' - ' . $this->faker->colorName . '123',
            'marca_id' => $this->faker->randomElement([1,2,3,4,5]),
        ];

        $response = $this->actingAs()->json('post', 'api/appliances', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseShow
            )
            ->decodeResponseJson();

        //verifica se inseriu
        $this->assertTrue(Eletrodomestico::find($response['data']['id']) != null);
    }

    public function testApplianceIsDestroyed()
    {
        $applianceData =
            [
                'descricao' => $this->faker->name . ' - ' . $this->faker->colorName . 1234,
                'marca_id' => $this->faker->randomElement([1,2,3,4,5]),
            ];

        $appliance = Eletrodomestico::create(
            $applianceData
        );

        $response = $this->actingAs()->json('delete', "api/appliances/$appliance->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                $this->defaultStructResponseShow
            )
            ->decodeResponseJson();

        //verifica se apagou
        $this->assertFalse(Eletrodomestico::find($response['data']['id']) != null);
    }

    public function testUpdateApplianceReturnsCorrectData()
    {
        $appliance = Eletrodomestico::create(
            [
                'descricao' => $this->faker->name . ' - ' . $this->faker->colorName . 12345,
                'marca_id' => $this->faker->randomElement([1,2,3,4,5]),
            ]
        );

        $payload =  [
            'descricao' => $this->faker->name . ' - ' . $this->faker->colorName . 123456,
            'marca_id' => $this->faker->randomElement([1,2,3,4,5]),
        ];

        $response = $this->actingAs()->json('put', "api/appliances/$appliance->id", $payload)
            ->assertStatus(Response::HTTP_OK)
            ->decodeResponseJson();

        $responseArr = (array)$response['data'];
        unset($responseArr['id']);
        unset($responseArr['created_at']);
        unset($responseArr['updated_at']);
        unset($responseArr['marca']);

        //verifica se atualizou certo
        self::assertTrue($responseArr === $payload);
    }

    public function testDestroyForMissingAppliance()
    {
        $this->actingAs()->json('delete', 'api/appliances/0')
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
