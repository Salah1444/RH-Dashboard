<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('net_etab', function (Blueprint $table) {
            $table->id('net_etab_id');
            $table->string('CD_NETAB', 30)->nullable()->unique();
            $table->string('LIBELLE_net_etab', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('net_etab');
    }
};
