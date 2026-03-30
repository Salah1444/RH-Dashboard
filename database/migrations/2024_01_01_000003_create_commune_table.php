<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commune', function (Blueprint $table) {
            $table->id('id_commune');
            $table->string('CD_COM', 20)->nullable()->unique();
            $table->string('LIB_COMMUNE_FR', 100)->nullable();
            $table->string('LIB_COMMUNE_AR', 100)->nullable();
            $table->string('LIB_MILIEU_FR', 50)->nullable();
            $table->string('LIB_MILIEU_AR', 50)->nullable();
            $table->foreignId('id_province')->nullable()->constrained('province', 'id_province')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commune');
    }
};
