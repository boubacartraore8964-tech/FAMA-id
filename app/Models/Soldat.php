<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soldat extends Model
{
    use HasFactory;

    // 🛡️ Sécurité : On autorise UNIQUEMENT ces champs à être remplis par un formulaire
    protected $fillable = [
        'nom',
        'prenom',
        'matricule',
        'telephone',
        'grade',
        'unite',
        'base_affectation',
        'photo_path',
        'photo_profil_gauche',
         'photo_profil_droit',
        'statut'
    ];

    // Relation : Un soldat peut avoir plusieurs vérifications
    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }
}