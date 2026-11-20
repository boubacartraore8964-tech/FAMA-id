<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 🛡️ On ajoute 'role', 'poste' et 'is_active' aux champs modifiables
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'poste',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // 🚀 Casting automatique en booléen
        ];
    }

    // Relation : Un vérificateur a fait plusieurs vérifications
    public function verifications()
    {
        return $this->hasMany(Verification::class, 'verificateur_id');
    }
}