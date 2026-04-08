<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectation', function (Blueprint $table) {
            $table->id('id_aff');
            $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->foreignId('code_etab')->nullable()->constrained('etablisement', 'CD_ETAB')->nullOnDelete();
            $table->foreignId('fonction_id')->nullable()->constrained('fonction', 'CODE_FONCTION')->nullOnDelete();
            $table->date('DT_AFF_POSTE')->nullable();
            $table->date('DATE_DEBUT_AFF')->nullable();
            $table->date('Date_aff_delegation')->nullable();
            $table->date('Date_aff_aref')->nullable();
            $table->string('Mode_Affectation', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectation');
    }
};
