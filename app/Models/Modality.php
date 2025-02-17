<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modality extends Model
{
    use HasFactory;

    protected $fillable = ['institution_id', 'name', 'modality_code'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}