<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'indikator_soca';

    public function ujianSoca()
    {
        return $this->belongsTo(UjianSoca::class, 'id_ujian');
    }

    public function hasilUjianSoca()
    {
        return $this->hasMany(HasilUjianSoca::class, 'id_indikator_soca');
    }
}
