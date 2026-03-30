<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('position', function (Blueprint $table) {
            $table->id('id_position');
            $table->string('COD_POS', 30)->nullable()->unique();
            $table->string('LIB_POSITION_FR', 200)->nullable();
            $table->string('LIB_POSITION_AR', 200)->nullable();
            $table->string('LIB_TYPE_POSITION_FR', 200)->nullable();
            $table->string('LIB_TYPE_POSITION_AR', 200)->nullable();
            $table->date('DATE_POSITION')->nullable();
            $table->string('type_position', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('position');
    }
};
