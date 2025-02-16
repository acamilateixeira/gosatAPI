<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class InstitutionController extends Controller
{
    public function fetch(Request $request): JsonResponse
    {
        $cpf = $request->input('cpf');

        $response = Http::post('https://dev.gosat.org/api/v1/simulacao/credito', [
            'cpf' => $cpf
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao consultar a API externa'], 500);
        }

        return response()->json($response->json());
    }
}