<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->date('tanggal_pelayanan');
            $table->time('jam_mulai')->default('08:00');
            $table->time('jam_selesai')->default('12:00');
            $table->string('jenis_pelayanan')->default('Pemeriksaan Rutin'); // Imunisasi, Pemeriksaan, dll
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['posyandu_id', 'tanggal_pelayanan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
