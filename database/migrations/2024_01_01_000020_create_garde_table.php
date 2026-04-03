<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garde', function (Blueprint $table) {
            $table->id('id_garde');
            $table->date('date_garde')->nullable();
            $table->string('nom_prenom_gardeur', 200)->nullable();
            $table->string('doti_gardeur', 50)->nullable();
            $table->string('cin_gardeur', 20)->nullable();
            $table->string('fonction_gardeur', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garde');
    }
};
