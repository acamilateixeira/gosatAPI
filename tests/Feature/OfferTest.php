<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class OfferTest extends TestCase
{
    public function test_fetch_credit_simulation()
    {
        Http::fake([
            'https://dev.gosat.org/api/v1/simulacao/oferta' => Http::response([
                'QntParcelaMin' => 12,
                'QntParcelaMax' => 48,
                'valorMin' => 3000,
                'valorMax' => 7000,
                'jurosMes' => 0.0365
            ], 200)
        ]);

        $response = $this->postJson('/api/credit-simulation', [
            'cpf' => '11111111111',
            'institution_id' => 2,
            'codModalidade' => 'a50ed2ed-2b8b-4cc7-ac95-71a5568b34ce'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'QntParcelaMin',
                'QntParcelaMax',
                'valorMin',
                'valorMax',
                'jurosMes'
            ]);
    }
}