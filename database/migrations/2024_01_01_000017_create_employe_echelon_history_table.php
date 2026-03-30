<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employe_echelon_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->constrained('employer', 'id_emp')->cascadeOnDelete();
            $table->foreignId('id_ech')->constrained('echelon', 'id_ech')->cascadeOnDelete();
            $table->string('INDICE', 20)->nullable();
            $table->string('ANC_ELO', 20)->nullable();
            $table->date('DAT_EFF_ELO')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employe_echelon_history');
    }
};
