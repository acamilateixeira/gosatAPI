<?php

namespace App\Models;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Institution",
 *     type="object",
 *     title="Institution",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="Banco PingApp"),
 *     }
 * )
 */
class Institution extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}