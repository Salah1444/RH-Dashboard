<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fonction', function (Blueprint $table) {
            $table->id('id_fon');
            $table->string('CODE_FONCTION', 30)->nullable()->unique();
            $table->string('LIB_FONCTION_FR', 200)->nullable();
            $table->string('LIB_FONCTION_AR', 200)->nullable();
            $table->date('DT_AFF_Fonction')->nullable();
            $table->string('LL_CYCLE', 100)->nullable();
            $table->string('LL_DISCIP', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fonction');
    }
};
