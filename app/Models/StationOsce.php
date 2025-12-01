<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationOsce extends Model
{
    use HasFactory;

    protected $table = "station_osce";

    protected $connection = 'osce';

    public function ujianOsce()
    {
        return $this->belongsTo(UjianOsce::class, 'id_ujian_osce');
    }

    public function penguji()
    {
        return $this->belongsTo(Penguji::class, 'id_penguji');
    }

    public function pesertaOsce()
    {
        return $this->hasMany(PesertaOsce::class, 'id_station');
    }

    public function kriteriaOsce()
    {
        return $this->belongsTo(KriteriaOsce::class, 'id_kriteria');
    }
}
