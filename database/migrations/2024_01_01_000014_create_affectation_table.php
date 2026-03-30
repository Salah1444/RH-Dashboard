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
            $table->foreignId('emp_id')->constrained('employer', 'id_emp')->cascadeOnDelete();
            $table->foreignId('etablissement_id')->nullable()->constrained('etablisement', 'id_etablisement')->nullOnDelete();
            $table->foreignId('fonction_id')->nullable()->constrained('fonction', 'id_fon')->nullOnDelete();
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
