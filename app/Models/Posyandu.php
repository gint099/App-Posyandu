<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Posyandu extends Model
{
    protected $fillable = [
        'nama_posyandu',
        'rw',
        'kelurahan',
        'kecamatan',
        'alamat',
        'ketua',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pasiens(): HasMany
    {
        return $this->hasMany(Pasien::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
