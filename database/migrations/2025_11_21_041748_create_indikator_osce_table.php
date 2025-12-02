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

            $table->unsignedBigInteger('id_kriteria');
            $table->foreign('id_kriteria')->references('id')->on('kriteria_osce');
            $table->string('nama');

            $table->enum("jenis_indikator", ['deskripsi', 'dokumen']);
            $table->text("deskripsi")->nullable();
            $table->string("dokumen")->nullable();

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
