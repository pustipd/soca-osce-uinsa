<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengujiSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'penguji_soca';

    public function pesertaSoca()
    {
        return $this->hasMany(PesertaSoca::class, 'id_penguji_soca');
    }

    public function ujianSoca()
    {
        return $this->belongsTo(UjianSoca::class, 'id_ujian_soca');
    }

    public function penguji1()
    {
        return $this->belongsTo(Penguji::class, 'id_penguji1');
    }

    public function penguji2()
    {
        return $this->belongsTo(Penguji::class, 'id_penguji2');
    }

    public function kriteriaSoca()
    {
        return $this->belongsTo(KriteriaSoca::class, 'id_kriteria');
    }

}
