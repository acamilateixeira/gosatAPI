<?php

namespace App\Models;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Offer",
 *     type="object",
 *     title="Offer",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="institution_id", type="integer", example=1),
 *         @OA\Property(property="cpf", type="string", example="11111111111"),
 *         @OA\Property(property="modality", type="string", example="crédito pessoal"),
 *         @OA\Property(property="interest_rate", type="number", format="float", example=0.0365),
 *         @OA\Property(property="min_installments", type="integer", example=12),
 *         @OA\Property(property="max_installments", type="integer", example=48),
 *         @OA\Property(property="min_amount", type="number", format="float", example=3000.00),
 *         @OA\Property(property="max_amount", type="number", format="float", example=7000.00),
 *     }
 * )
 */
class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id',
        'cpf',
        'modality',
        'interest_rate',
        'min_installments',
        'max_installments',
        'min_amount',
        'max_amount'
    ];
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}