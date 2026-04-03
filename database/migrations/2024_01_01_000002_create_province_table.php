<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('province', function (Blueprint $table) {
            $table->id('CD_PRV');
            $table->string('LIB_PROVINCE_FR', 100)->nullable();
            $table->string('LIB_PROVINCE_AR', 100)->nullable();
            $table->foreignId('CD_REG')->nullable()->constrained('region', 'CD_REG')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('province');
    }
};
