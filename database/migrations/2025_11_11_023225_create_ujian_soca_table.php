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
        Schema::create('ujian_soca', function (Blueprint $table) {
            $table->id();
            $table->string("nama", 100);
            $table->integer("sesi");
            $table->dateTime('waktu');
            $table->string("kriteria");

            // $table->unsignedBigInteger('id_kriteria');
            // $table->foreign('id_kriteria')->references('id')->on('kriteria_soca');

            $table->integer("batasnilai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_soca');
    }
};
