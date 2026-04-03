<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conjoints', function (Blueprint $table) {
            $table->id('id_conj');
            $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->date('DATE_SIT_FAM')->nullable();
            $table->string('nom_prenom_conjoint', 200)->nullable();
            $table->integer('rang_conj')->nullable();
            $table->string('cin_conj', 20)->nullable();
            $table->string('doti_conj', 50)->nullable();
            $table->string('nationalite_conj', 80)->nullable();
            $table->string('fonction_conj', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conjoints');
    }
};
