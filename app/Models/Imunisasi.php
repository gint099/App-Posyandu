<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imunisasi extends Model
{
    protected $fillable = [
        'pasien_id',
        'user_id',
        'jenis_imunisasi',
        'tanggal_imunisasi',
        'usia_bulan_saat_imunisasi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_imunisasi' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
