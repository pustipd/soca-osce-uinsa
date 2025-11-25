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
        Schema::create('peserta_osce', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('id_mahasiswa');
            // $table->foreign('id_mahasiswa')->references('id')->on('kriteria_soca');

            $table->unsignedBigInteger('id_station');
            $table->foreign('id_station')->references('id')->on('station_osce');

            $table->enum("status", ['terjadwal', 'aktif', 'tidak hadir', 'selesai'])->nullable();
            $table->integer("skor")->nullable();
            $table->text("feedback")->nullable();
            $table->integer("rotasi")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_osce');
    }
};
