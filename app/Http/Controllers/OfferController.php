<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchOffersRequest;
use App\Http\Requests\SimulateOfferRequest;
use App\Services\OfferService;
use Illuminate\Http\JsonResponse;

class OfferController extends Controller
{
    private OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    /**
     * @OA\Post(
     *     path="/api/credit-offer",
     *     tags={"Ofertas de Crédito"},
     *     summary="Buscar ofertas de crédito por CPF",
     *     description="Retorna as ofertas de crédito disponíveis para um CPF específico.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf"},
     *             @OA\Property(property="cpf", type="string", example="12345678901")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ofertas de crédito",
     *         @OA\JsonContent(
     *             @OA\Property(property="instituicoes", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Banco XYZ"),
     *                 @OA\Property(property="modalidades", type="array", @OA\Items(
     *                     @OA\Property(property="cod", type="string", example="001"),
     *                     @OA\Property(property="nome", type="string", example="Crédito Pessoal")
     *                 ))
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=400, description="CPF inválido"),
     *     @OA\Response(response=500, description="Erro interno do servidor")
     * )
     */
    public function fetchOffers(FetchOffersRequest $request): JsonResponse
    {
        $offers = $this->offerService->fetchOffers($request->cpf);

        if ($offers->isEmpty()) {
            return response()->json(['message' => 'Nenhuma oferta encontrada.'], 404);
        }

        return response()->json($offers);
    }

    /**
     * @OA\Post(
     *     path="/api/credit-simulation",
     *     tags={"Simulação de Crédito"},
     *     summary="Simula uma oferta de crédito",
     *     description="Simula uma oferta de crédito para um CPF em uma instituição e modalidade específica.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf", "institution_id", "codModalidade"},
     *             @OA\Property(property="cpf", type="string", example="12345678901"),
     *             @OA\Property(property="institution_id", type="integer", example=1),
     *             @OA\Property(property="codModalidade", type="string", example="001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resultado da simulação",
     *         @OA\JsonContent(
     *             @OA\Property(property="valorMin", type="number", example=5000.00),
     *             @OA\Property(property="valorMax", type="number", example=8000.00),
     *             @OA\Property(property="jurosMes", type="number", example=0.0495),
     *             @OA\Property(property="QntParcelaMin", type="integer", example=12),
     *             @OA\Property(property="QntParcelaMax", type="integer", example=48)
     *         )
     *     ),
     *     @OA\Response(response=404, description="Nenhuma simulação encontrada"),
     *     @OA\Response(response=500, description="Erro interno do servidor")
     * )
     */
    public function simulateOffer(SimulateOfferRequest $request): JsonResponse
    {
        try {
            $data = $this->offerService->simulateOffer(
                $request->cpf,
                $request->institution_id,
                $request->codModalidade
            );

            if (!$data) {
                return response()->json(['error' => 'Nenhuma simulação encontrada.'], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}