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
        Schema::create('hasil_ujian_osce', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_peserta_osce');
            $table->foreign('id_peserta_osce')->references('id')->on('peserta_osce');

            $table->unsignedBigInteger('id_indikator_osce');
            $table->foreign('id_indikator_osce')->references('id')->on('indikator_osce');

            $table->integer("skor")->nullable();
            $table->integer("bobot")->nullable();
            $table->string("hash")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian_osce');
    }
};
