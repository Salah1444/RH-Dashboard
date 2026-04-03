<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadre', function (Blueprint $table) {
            $table->id('id_cadre');
            $table->string('CADRE', 50)->nullable();
            $table->string('Lib_cadre_AR', 200)->nullable();
            $table->string('Lib_Cadre_FR', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadre');
    }
};
