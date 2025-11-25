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
        Schema::create('indikator_soca', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ujian');
            $table->foreign('id_ujian')->references('id')->on('ujian_soca');
            $table->string("nama");
            $table->text("deskripsi");
            $table->integer("skormax");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_soca');
    }
};
