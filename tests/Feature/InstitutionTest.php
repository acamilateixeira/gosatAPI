<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class InstitutionTest extends TestCase
{
    public function test_fetch_credit_offers()
    {
        Http::fake([
            'https://dev.gosat.org/api/v1/simulacao/credito' => Http::response([
                'instituicoes' => [
                    [
                        'id' => 1,
                        'nome' => 'Banco PingApp',
                        'modalidades' => [
                            ['nome' => 'crédito pessoal', 'cod' => '3']
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->postJson('/api/credit-offer', ['cpf' => '11111111111']);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'instituicoes' => [
                    '*' => ['id', 'nome', 'modalidades']
                ]
            ]);
    }
}