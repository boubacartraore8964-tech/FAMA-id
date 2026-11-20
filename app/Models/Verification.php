<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'verificateur_id',
        'soldat_id',
        'resultat',
        'date_heure'
    ];

    // Relation : Une vérification est faite par un vérificateur (User)
    public function verificateur()
    {
        return $this->belongsTo(User::class, 'verificateur_id');
    }

    // Relation : Une vérification concerne un soldat
    public function soldat()
    {
        return $this->belongsTo(Soldat::class);
    }

    // Relation : Une vérification peut générer une alerte
    public function alerte()
    {
        return $this->hasOne(Alerte::class);
    }
}