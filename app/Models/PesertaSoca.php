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

    public function penguji1()
    {
        return $this->belongsTo(Penguji::class, 'id_penguji1');
    }

    public function penguji2()
    {
        return $this->belongsTo(Penguji::class, 'id_penguji2');
    }

    public function ujianSoca()
    {
        return $this->belongsTo(UjianSoca::class, 'id_ujian_soca');
    }

    public function hasilUjianSoca()
    {
        return $this->hasMany(HasilUjianSoca::class, 'id_peserta_soca');
    }
}
