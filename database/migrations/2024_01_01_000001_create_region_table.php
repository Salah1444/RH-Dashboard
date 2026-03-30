<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('region', function (Blueprint $table) {
            $table->id('id_region');
            $table->string('CD_REG', 20)->nullable()->unique();
            $table->string('LIB_REGION_FR', 100)->nullable();
            $table->string('LIB_REGION_AR', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region');
    }
};
