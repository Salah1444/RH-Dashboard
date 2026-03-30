<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablisement', function (Blueprint $table) {
            $table->id('id_etablisement');
            $table->string('CD_ETAB', 30)->nullable()->unique();
            $table->string('LIBELLE_FR_AFF', 200)->nullable();
            $table->string('LIBELLE_AR_AFF', 200)->nullable();
            $table->string('type_milieu', 50)->nullable();
            $table->integer('Nombre_eleves')->nullable();
            $table->string('Disponibilite_logement', 50)->nullable();
            $table->foreignId('commune_id')->nullable()->constrained('commune', 'id_commune')->nullOnDelete();
            $table->foreignId('modiriya_id')->nullable()->constrained('modiriya', 'modiriya_id')->nullOnDelete();
            $table->foreignId('net_etab_id')->nullable()->constrained('net_etab', 'net_etab_id')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etablisement');
    }
};
