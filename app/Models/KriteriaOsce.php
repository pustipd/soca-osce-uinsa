<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaOsce extends Model
{
    use HasFactory;

    protected $table = 'kriteria_osce';

    protected $connection = 'osce';

    public function indikatorOsce()
    {
        return $this->hasMany(IndikatorOsce::class, 'id_kriteria');
    }

    public function stationOsce()
    {
        return $this->hasMany(StationOsce::class, 'id_kriteria');
    }

}
