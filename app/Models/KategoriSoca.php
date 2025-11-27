<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoca extends Model
{
    use HasFactory;

    protected $connection = 'soca';
    protected $table = 'kategori_soca';

    public function indikatorSoca()
    {
        return $this->hasMany(IndikatorSoca::class, 'id_kategori');
    }
}
