<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            
            // Lien avec la vérification qui a échoué
            $table->foreignId('verification_id')->nullable()->constrained('verifications')->cascadeOnDelete();
            
            $table->enum('type', ['inconnu', 'fraude', 'suspendu']);
            $table->text('message');
            
            // 🛡️ Pour que l'admin puisse dire "J'ai vu l'alerte"
            $table->enum('statut', ['ouverte', 'traitee'])->default('ouverte')->index();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};