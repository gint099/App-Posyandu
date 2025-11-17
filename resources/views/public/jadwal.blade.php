@extends('layouts.app')

@section('title', 'Jadwal Pelayanan Posyandu')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <i class="fas fa-calendar-alt fa-4x text-primary mb-3"></i>
        <h2 class="fw-bold">Jadwal Pelayanan Posyandu</h2>
        <p class="text-muted">Lihat jadwal pelayanan posyandu di wilayah Anda</p>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('public.jadwal') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Posyandu</label>
                        <select name="posyandu_id" class="form-select">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $p)
                                <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_posyandu }} (RW {{ $p->rw }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="show_all"
                        id="show_all"
                        {{ request('show_all') ? 'checked' : '' }}
                        onchange="this.form.submit()"
                    >
                    <label class="form-check-label" for="show_all">
                        Tampilkan semua jadwal (termasuk yang sudah lewat)
                    </label>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Jadwal -->
    @if($jadwals->count() > 0)
        <div class="row">
            @foreach($jadwals as $jadwal)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm
                        @if($jadwal->tanggal_pelayanan->isToday()) border-danger border-2
                        @elseif($jadwal->tanggal_pelayanan->isTomorrow()) border-warning border-2
                        @else border-primary
                        @endif
                    ">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">{{ $jadwal->posyandu->nama_posyandu }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $jadwal->posyandu->alamat }}
                                    </p>
                                </div>
                                @if($jadwal->tanggal_pelayanan->isToday())
                                    <span class="badge bg-danger">Hari Ini</span>
                                @elseif($jadwal->tanggal_pelayanan->isTomorrow())
                                    <span class="badge bg-warning">Besok</span>
                                @elseif($jadwal->tanggal_pelayanan->isFuture())
                                    @php
                                        $daysUntil = now()->diffInDays($jadwal->tanggal_pelayanan);
                                    @endphp
                                    <span class="badge bg-info">{{ $daysUntil }} Hari Lagi</span>
                                @else
                                    <span class="badge bg-secondary">Sudah Lewat</span>
                                @endif
                            </div>

                            <hr>

                            <div class="mb-2">
                                <i class="fas fa-calendar text-primary"></i>
                                <strong>{{ $jadwal->tanggal_pelayanan->isoFormat('dddd, D MMMM Y') }}</strong>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock text-success"></i>
                                <strong>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</strong>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-medkit text-info"></i>
                                <span class="badge bg-info">{{ $jadwal->jenis_pelayanan }}</span>
                            </div>
                            @if($jadwal->keterangan)
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> {{ $jadwal->keterangan }}
                                    </small>
                                </div>
                            @endif

                            @if($jadwal->posyandu->ketua)
                                <hr>
                                <div class="small">
                                    <strong>Ketua:</strong> {{ $jadwal->posyandu->ketua }}
                                    @if($jadwal->posyandu->phone)
                                        <br><strong>Kontak:</strong> {{ $jadwal->posyandu->phone }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $jadwals->links() }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5>Tidak Ada Jadwal</h5>
                <p class="text-muted">Tidak ada jadwal pelayanan untuk filter yang dipilih</p>
                <a href="{{ route('public.jadwal') }}" class="btn btn-primary">
                    <i class="fas fa-sync"></i> Reset Filter
                </a>
            </div>
        </div>
    @endif

    <!-- Info Panel -->
    <div class="card bg-light mt-5">
        <div class="card-body">
            <h6><i class="fas fa-info-circle text-info"></i> Informasi Penting</h6>
            <ul class="mb-0">
                <li>Harap datang tepat waktu sesuai jadwal yang tertera</li>
                <li>Bawa buku KIA (Kesehatan Ibu dan Anak) saat berkunjung</li>
                <li>Jadwal dapat berubah sewaktu-waktu, harap konfirmasi ke kader posyandu</li>
                <li>Untuk informasi lebih lanjut, hubungi kader posyandu setempat</li>
            </ul>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
