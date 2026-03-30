<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enfants', function (Blueprint $table) {
            $table->id('id_enf');
            $table->foreignId('emp_id')->constrained('employer', 'id_emp')->cascadeOnDelete();
            $table->foreignId('gard_id')->nullable()->constrained('garde', 'id_garde')->nullOnDelete();
            $table->string('nom_prenom_enf', 200)->nullable();
            $table->integer('rang_enf')->nullable();
            $table->date('date_naissance_enf')->nullable();
            $table->string('lien_juridique', 100)->nullable();
            $table->string('situation_enf', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enfants');
    }
};
