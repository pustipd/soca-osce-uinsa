<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'ujian_soca';

    public function pesertaSoca()
    {
        return $this->hasMany(PesertaSoca::class, 'id_ujian_soca');
    }

    public function kriteriaSoca()
    {
        return $this->belongsTo(KriteriaSoca::class, 'id_kriteria');
    }
}
