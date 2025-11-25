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
        Schema::create('indikator_osce', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_ujian');
            $table->foreign('id_ujian')->references('id')->on('ujian_osce');
            $table->string('nama');

            $table->text('deskripsi');
            $table->integer("skormax");
            $table->integer("bobot");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_osce');
    }
};
