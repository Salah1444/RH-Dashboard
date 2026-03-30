<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employer', function (Blueprint $table) {
            $table->id('id_emp');
            $table->string('COD_AG', 30)->nullable()->unique();
            $table->string('CIN_A', 20)->nullable();
            $table->string('CIN_N', 20)->nullable();
            $table->string('CIN', 20)->nullable()->unique();
            $table->string('NOM_PRENOM_FR', 200)->nullable();
            $table->string('NOM_PRENOM_AR', 200)->nullable();
            $table->string('photo', 255)->nullable();
            $table->date('DATE_NAISS')->nullable();
            $table->string('LIEU_NAIS', 150)->nullable();
            $table->enum('SEXE', ['M', 'F'])->nullable();
            $table->string('CODE_NAT', 20)->nullable();
            $table->string('ADRESSE_FR', 255)->nullable();
            $table->string('ADRESSE_AR', 255)->nullable();
            $table->string('VILLE', 100)->nullable();
            $table->string('TEL_FIXE', 20)->nullable();
            $table->string('TEL_PORTABLE', 20)->nullable();
            $table->string('ADRESSE_ELEC', 150)->nullable();
            $table->string('SIT_F_AG', 50)->nullable();
            $table->string('Sit_Familiale', 100)->nullable();
            $table->string('RIB', 30)->nullable();
            $table->string('NUM_PB', 30)->nullable();
            $table->string('CD_DIPP', 20)->nullable();
            $table->string('LL_DIPP', 200)->nullable();
            $table->string('CD_DIPS', 20)->nullable();
            $table->string('LL_DIPS', 200)->nullable();
            $table->date('DT_DIPPROF')->nullable();
            $table->date('DT_DIPSCOL')->nullable();
            $table->foreignId('ville_id')->nullable()->constrained('commune', 'id_commune')->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('position', 'id_position')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer');
    }
};
