<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CPFQuery extends Model
{
    use HasFactory;

    protected $table = 'cpf_queries';

    protected $fillable = ['cpf'];

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}