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
        Schema::create('ujian_osce', function (Blueprint $table) {
            $table->id();
            $table->string("nama", 100);
            $table->integer("sesi");
            $table->date("waktu");
            $table->string("kriteria");
            $table->boolean("status");

            // $table->unsignedBigInteger('id_kriteria');
            // $table->foreign('id_kriteria')->references('id')->on('kriteria_osce');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_osce');
    }
};
