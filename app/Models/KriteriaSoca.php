<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'kriteria_soca';

    public function ujianSoca()
    {
        return $this->hasMany(UjianSoca::class, 'id_kriteria');
    }

    public function indikatorSoca()
    {
        return $this->hasMany(IndikatorSoca::class, 'id_kriteria');
    }
}
