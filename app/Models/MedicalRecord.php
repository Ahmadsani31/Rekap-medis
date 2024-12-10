<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $table = 'medical_record';

    protected $fillable = [
        'pasien_id',
        'docter_id',
        'ruang_id',
        'obat_id',
        'keluhan',
        'diagnosa',
    ];

    public function getDocter(): BelongsTo
    {
        return $this->belongsTo(Docter::class, 'docter_id');
    }

    public function getPasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function getRuangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruang_id');
    }
}
