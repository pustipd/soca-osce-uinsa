<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $connection = 'osce';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kriteria_osce', function (Blueprint $table) {
            $table->id();
            $table->string("nama", 100);
            $table->integer("totalnilai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_osce');
    }
};
