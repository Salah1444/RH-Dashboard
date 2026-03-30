<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('province', function (Blueprint $table) {
            $table->id('id_province');
            $table->string('CD_PRV', 20)->nullable()->unique();
            $table->string('LIB_PROVINCE_FR', 100)->nullable();
            $table->string('LIB_PROVINCE_AR', 100)->nullable();
            $table->foreignId('id_region')->nullable()->constrained('region', 'id_region')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('province');
    }
};
