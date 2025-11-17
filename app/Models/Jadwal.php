<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $fillable = [
        'posyandu_id',
        'tanggal_pelayanan',
        'jam_mulai',
        'jam_selesai',
        'jenis_pelayanan',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'tanggal_pelayanan' => 'date',
        'is_active' => 'boolean',
    ];

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }
}
