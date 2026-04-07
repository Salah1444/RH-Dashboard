<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diplomes', function (Blueprint $table) {
            $table->id('CD_DIP');
            $table->string('LL_DIP', 200)->nullable();
            $table->date('DT_DIP')->nullable();
             $table->foreignId('code_agent')->constrained('employer', 'COD_AG')->cascadeOnDelete();
            $table->string('etablissement_formation', 200)->nullable();
            $table->float('montion')->nullable();
            $table->enum('TYPE_DIP', ['SCOLAIRE', 'PRO']);
            $table->string('PDF', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diplomes');
    }
};
