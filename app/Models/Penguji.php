<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penguji extends Authenticatable
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'penguji';

    public function pesertaSoca()
    {
        return $this->hasMany(PesertaSoca::class, 'id_penguji1');
    }
}
