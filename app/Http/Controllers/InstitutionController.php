<?php

namespace App\Http\Controllers;

use App\Http\Requests\FetchInstitutionsRequest;
use App\Services\InstitutionService;
use Illuminate\Http\JsonResponse;

class InstitutionController extends Controller
{
    private InstitutionService $institutionService;

    public function __construct(InstitutionService $institutionService)
    {
        $this->institutionService = $institutionService;
    }

    /**
     * @OA\Post(
     *     path="/api/institutions",
     *     tags={"Instituições"},
     *     summary="Consulta instituições financeiras disponíveis",
     *     description="Retorna a lista de instituições financeiras disponíveis para um CPF específico.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"cpf"},
     *             @OA\Property(property="cpf", type="string", example="12345678901")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de instituições",
     *         @OA\JsonContent(
     *             @OA\Property(property="instituicoes", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nome", type="string", example="Banco XYZ")
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=400, description="CPF inválido"),
     *     @OA\Response(response=500, description="Erro interno do servidor")
     * )
     */
    public function fetchInstitutions(FetchInstitutionsRequest $request): JsonResponse
    {
        try {
            $data = $this->institutionService->fetchInstitutions($request->cpf);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}