<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docter extends Model
{
    protected $table = 'docter';

    protected $fillable = [
        'name',
        'email',
        'no_handphone',
        'alamat',
        'spesialis',
        'jenis_kelamin',
        'profil'
    ];
}
