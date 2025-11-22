<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaOsce extends Model
{
    use HasFactory;

    protected $table = "peserta_osce";

    protected $connection = 'osce';

    public function stationOsce()
    {
        return $this->belongsTo(StationOsce::class, 'id_station');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function hasilUjianOsce()
    {
        return $this->hasMany(HasilUjianOsce::class, 'id_peserta_osce');
    }

}
