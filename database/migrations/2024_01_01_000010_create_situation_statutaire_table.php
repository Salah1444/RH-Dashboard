<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('situation_statutaire', function (Blueprint $table) {
            $table->id('sit_st_id');
            $table->string('CODE_SIT_STATUTAIRE', 30)->nullable()->unique();
            $table->string('LIB_SITUATION_STATUTAIRE_FR', 200)->nullable();
            $table->string('LIB_SITUATION_STATUTAIRE_AR', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('situation_statutaire');
    }
};
