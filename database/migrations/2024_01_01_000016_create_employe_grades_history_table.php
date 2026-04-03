<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employe_grades_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->foreignId('id_grade')->constrained('grade', 'id_grade')->cascadeOnDelete();
            $table->string('ANC_GRADE', 20)->nullable();
            $table->date('DAT_EFF_GR')->nullable();
            $table->string('MOD_AV_GRADE', 100)->nullable();
            $table->string('LIBELLE_GRADE', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employe_grades_history');
    }
};
