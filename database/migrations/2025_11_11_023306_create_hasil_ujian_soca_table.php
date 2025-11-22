<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'soca';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_ujian_soca', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_peserta_soca');
            // $table->foreign('id_peserta_soca')->references('id')->on('mahasiswa');

            $table->unsignedBigInteger('id_indikator_soca');
            // $table->foreign('id_indikator_soca')->references('id')->on('mahasiswa');

            $table->integer("skor1")->nullable();
            $table->integer("skor2")->nullable();
            $table->string("hash")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian_soca');
    }
};
