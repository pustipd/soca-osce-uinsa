<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilUjianSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'hasil_ujian_soca';

    public function pesertaSoca()
    {
        return $this->belongsTo(pesertaSoca::class, 'id_peserta_soca');
    }
}
