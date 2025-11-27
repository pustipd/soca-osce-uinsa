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
        Schema::create('peserta_soca', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_mahasiswa');
            // $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');

            $table->unsignedBigInteger('id_penguji_soca');
            $table->foreign('id_penguji_soca')->references('id')->on('penguji_soca');

            $table->enum("status", ['terjadwal', 'sedang', 'tidak sinkron', 'sinkron', 'tidak hadir', 'selesai'])->nullable();
            $table->string("totalskor1")->nullable();
            $table->string("totalskor2")->nullable();

            $table->integer("urutan")->nullable();
            $table->enum("rating", ["tidak lulus", "borderline", "lulus", "superior"])->default("tidak lulus");

            $table->text("feedback")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_soca');
    }
};
