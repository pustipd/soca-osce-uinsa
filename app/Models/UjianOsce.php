<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianOsce extends Model
{
    use HasFactory;

    protected $table = "ujian_osce";

    protected $connection = 'osce';

    public function stationOsce()
    {
        return $this->hasMany(StationOsce::class, 'id_ujian_osce');
    }

    public function indikatorOsce()
    {
        return $this->hasMany(IndikatorOsce::class, 'id_ujian');
    }
}
