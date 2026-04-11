<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etablissement', function (Blueprint $table) {
            $table->id('CD_ETAB');
            $table->string('NOM_ETAB', 200)->nullable();
            $table->string('type_milieu', 50)->nullable();
            $table->integer('Nombre_eleves')->nullable();
            $table->string('Disponibilite_logement', 50)->nullable();
            $table->foreignId('cd_commune')->nullable()->constrained('commune', 'CD_COM')->nullOnDelete();
            $table->foreignId('modiriya_id')->nullable()->constrained('modiriya', 'modiriya_id')->nullOnDelete();
            $table->foreignId('CD_NETAB')->nullable()->constrained('net_etab', 'CD_NETAB')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etablissement');
    }
};
