<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class OfferController extends Controller
{
    public function simulate(Request $request): JsonResponse
    {
        $cpf = $request->input('cpf');
        $institutionId = $request->input('institution_id');
        $modalityCode = $request->input('codModalidade');

        $response = Http::post('https://dev.gosat.org/api/v1/simulacao/oferta', [
            'cpf' => $cpf,
            'instituicao_id' => $institutionId,
            'codModalidade' => $modalityCode
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao consultar a API externa'], 500);
        }

        return response()->json($response->json());
    }
}