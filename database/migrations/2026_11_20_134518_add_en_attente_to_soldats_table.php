<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE soldats MODIFY COLUMN statut ENUM('actif', 'suspendu', 'en_attente') DEFAULT 'actif'");
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE soldats MODIFY COLUMN statut ENUM('actif', 'suspendu') DEFAULT 'actif'");
    }
};