<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;

    protected $fillable = [
        'verification_id',
        'type',
        'message',
        'statut'
    ];

    // Relation : L'alerte est liée à la vérification qui l'a déclenchée
    public function verification()
    {
        return $this->belongsTo(Verification::class);
    }
}