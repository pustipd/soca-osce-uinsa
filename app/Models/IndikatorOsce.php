<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorOsce extends Model
{
    use HasFactory;

    protected $table = "indikator_osce";

    protected $connection = 'osce';

    public function ujianOsce()
    {
        return $this->belongsTo(UjianOsce::class, 'id_ujian');
    }

    public function hasilUjianOsce()
    {
        return $this->hasMany(HasilUjianOsce::class, 'id_indikator_osce');
    }
}
