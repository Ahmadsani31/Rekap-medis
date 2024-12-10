<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'name',
        'no_handphone',
        'alamat',
        'nik',
        'jenis_kelamin',
    ];
}
