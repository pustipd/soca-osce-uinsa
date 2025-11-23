<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'indikator_soca';

    public function kriteriaSoca()
    {
        return $this->belongsTo(KriteriaSoca::class, 'id_kriteria');
    }

    public function hasilUjianSoca()
    {
        return $this->hasMany(HasilUjianSoca::class, 'id_indikator_soca');
    }
}
