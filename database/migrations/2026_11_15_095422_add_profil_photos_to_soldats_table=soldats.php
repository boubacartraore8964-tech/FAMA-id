<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('soldats', function (Blueprint $table) {
            $table->string('photo_profil_gauche')->nullable();
            $table->string('photo_profil_droit')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('soldats', function (Blueprint $table) {
            $table->dropColumn(['photo_profil_gauche', 'photo_profil_droit']);
        });
    }
};