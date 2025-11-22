<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'mahasiswa';

    public function pesertaSoca()
    {
        return $this->hasMany(PesertaSoca::class, 'id_mahasiswa');
    }
}
