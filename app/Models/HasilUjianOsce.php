<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjianOsce extends Model
{
    use HasFactory;

    protected $table = "hasil_ujian_osce";

    protected $connection = 'osce';

    public function pesertaOsce()
    {
        return $this->belongsTo(PesertaOsce::class, 'id_peserta_osce');
    }

    public function indikatorOsce()
    {
        return $this->belongsTo(IndikatorOsce::class, 'id_indikator_osce');
    }
}
