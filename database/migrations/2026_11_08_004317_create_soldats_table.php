<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soldats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            // 🚀 Optimisation : unique() empêche les doublons, index() rend la recherche ultra-rapide
            $table->string('matricule')->unique()->index(); 
            $table->string('telephone')->nullable();
            $table->string('grade');
            $table->string('unite');
            $table->string('base_affectation');
            
            // Photo stockée dans le dossier public (on ajoutera la logique de sécurité plus tard)
            $table->string('photo_path')->nullable(); 
            
            // 🛡️ Sécurité : Statut limité à des choix précis
            $table->enum('statut', ['actif', 'suspendu'])->default('actif');
            $table->timestamps(); // Ajoute created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soldats');
    }
};