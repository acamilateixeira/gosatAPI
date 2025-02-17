<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf_query_id',
        'modality_id',
        'interest_rate',
        'min_installments',
        'max_installments',
        'min_amount',
        'max_amount'
    ];

    public function cpfQuery()
    {
        return $this->belongsTo(CPFQuery::class);
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }
}