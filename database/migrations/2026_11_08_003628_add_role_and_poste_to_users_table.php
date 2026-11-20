<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 🛡️ Sécurité : Enum empêche d'avoir d'autres rôles que ceux définis
            $table->enum('role', ['admin', 'verificateur'])->default('verificateur');
            // Nullable car un admin n'est pas forcément affecté à un poste de garde
            $table->string('poste')->nullable(); 
            // Statut du compte (Actif ou Suspendu)
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'poste', 'is_active']);
        });
    }
};