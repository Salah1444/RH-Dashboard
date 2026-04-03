<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commune', function (Blueprint $table) {
            $table->id('CD_COM');
            $table->string('LIB_COMMUNE_FR')->nullable();
            $table->string('LIB_COMMUNE_AR')->nullable();
            $table->string('LIB_MILIEU_FR')->nullable();
            $table->string('LIB_MILIEU_AR')->nullable();
            $table->foreignId('CD_PRV')->nullable()->constrained('province', 'CD_PRV')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commune');
    }
};
