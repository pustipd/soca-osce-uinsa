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
        Schema::create('penguji_soca', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_ujian_soca');
            $table->foreign('id_ujian_soca')->references('id')->on('ujian_soca');

            $table->unsignedBigInteger('id_penguji1');

            $table->unsignedBigInteger('id_penguji2');

            $table->unsignedBigInteger('id_kriteria');
            $table->foreign('id_kriteria')->references('id')->on('kriteria_soca');

            $table->integer('station');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguji_soca');
    }
};
