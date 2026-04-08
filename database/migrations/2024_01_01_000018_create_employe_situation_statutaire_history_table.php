<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employe_situation_statutaire_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->foreignId('sit_st_id')->constrained('situation_statutaire', 'sit_st_id')->cascadeOnDelete();
            $table->date('DATE_SIT_STAT')->nullable();
            $table->date('DATE_PREV_RETRAITE')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employe_situation_statutaire_history');
    }
};
