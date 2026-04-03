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
            $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->foreignId('id_cadre')->constrained('cadre', 'id_cadre')->cascadeOnDelete();
            $table->string('ANC_ADM', 20)->nullable();
            $table->date('DT_AFF_Cadre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employe_cadre_history');
    }
};
