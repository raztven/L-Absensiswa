<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterangan extends Model
{
    protected $table = 'keterangan';

    protected $fillable = ['keterangan'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_keterangan');
    }
}