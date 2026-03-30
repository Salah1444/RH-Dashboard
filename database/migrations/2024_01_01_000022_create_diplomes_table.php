<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diplomes', function (Blueprint $table) {
            $table->id('id_diplome');
            $table->foreignId('emp_id')->constrained('employer', 'id_emp')->cascadeOnDelete();
            $table->string('CD_DIPP', 20)->nullable();
            $table->string('LL_DIPP', 200)->nullable();
            $table->string('CD_DIPS', 20)->nullable();
            $table->string('LL_DIPS', 200)->nullable();
            $table->date('DT_DIPPROF')->nullable();
            $table->date('DT_DIPSCOL')->nullable();
            $table->string('etablissement_formation', 200)->nullable();
            $table->string('specialite_montion', 200)->nullable();
            $table->string('type_dip', 100)->nullable();
            $table->date('date_obtenue')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diplomes');
    }
};
