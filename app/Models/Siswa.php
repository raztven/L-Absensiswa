<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'id_keterangan',
        'absenmasuk',
        'absenkeluar',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keteranganData()
    {
        return $this->belongsTo(Keterangan::class, 'id_keterangan');
    }
}