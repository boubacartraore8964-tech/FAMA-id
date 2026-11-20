<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers l'utilisateur (vérificateur). Si le vérificateur est supprimé, on garde l'historique.
            $table->foreignId('verificateur_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Clé étrangère vers le soldat. Nullable car si c'est un inconnu, il n'y a pas de soldat_id.
            $table->foreignId('soldat_id')->nullable()->constrained('soldats')->nullOnDelete();
            
            // 🛡️ Sécurité : Résultats stricts
            $table->enum('resultat', ['reconnu', 'non_reconnu', 'fraude']);
            
            // 🚀 Optimisation : index() pour afficher l'historique rapidement (tri par date)
            $table->timestamp('date_heure')->useCurrent()->index(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};