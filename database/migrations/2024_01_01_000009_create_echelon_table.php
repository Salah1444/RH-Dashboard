<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('echelon', function (Blueprint $table) {
            $table->id('id_ech');
            $table->string('COD_ECH', 20)->nullable();
            $table->string('COD_ELO', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('echelon');
    }
};
