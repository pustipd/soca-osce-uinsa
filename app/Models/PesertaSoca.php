<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'peserta_soca';

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function pengujiSoca()
    {
        return $this->belongsTo(PengujiSoca::class, 'id_penguji_soca');
    }

    public function hasilUjianSoca()
    {
        return $this->hasMany(HasilUjianSoca::class, 'id_peserta_soca');
    }
}
