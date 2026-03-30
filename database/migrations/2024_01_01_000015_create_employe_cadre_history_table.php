<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employe_cadre_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->constrained('employer', 'id_emp')->cascadeOnDelete();
            $table->foreignId('id_cadre')->constrained('cadre', 'id_cadre')->cascadeOnDelete();
            $table->string('ANC_ADM', 20)->nullable();
            $table->date('DT_AFF_Cadr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employe_cadre_history');
    }
};
