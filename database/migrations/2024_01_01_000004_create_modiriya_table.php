<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modiriya', function (Blueprint $table) {
            $table->id('modiriya_id');
            $table->string('nom_modiriya', 150)->nullable();
            $table->foreignId('id_region')->nullable()->constrained('region', 'CD_REG')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modiriya');
    }
};
