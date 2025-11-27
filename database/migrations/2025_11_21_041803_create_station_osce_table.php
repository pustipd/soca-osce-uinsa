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
        Schema::create('station_osce', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_penguji')->nullable();
            // $table->foreign('id_penguji')->references('id')->on('penguji');

            $table->unsignedBigInteger('id_ujian_osce')->nullable();
            $table->foreign('id_ujian_osce')->references('id')->on('ujian_osce');

            $table->unsignedBigInteger('id_kriteria')->nullable();
            $table->foreign('id_kriteria')->references('id')->on('kriteria_osce');

            $table->integer("no_station");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_osce');
    }
};
