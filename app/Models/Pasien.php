<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'phone_ortu',
        'posyandu_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function imunisasis(): HasMany
    {
        return $this->hasMany(Imunisasi::class);
    }

    // Helper method untuk menghitung usia
    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir->diffInMonths(now());
    }
}
