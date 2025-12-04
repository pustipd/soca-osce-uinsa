<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penguji', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 25);
            $table->string('password')->nullable();
            $table->string('nidn', 20);
            $table->string('nama', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguji');
    }
};
