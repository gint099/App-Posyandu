<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Kader yang input
            $table->date('tanggal_pemeriksaan');
            $table->integer('usia_bulan'); // Usia saat pemeriksaan (dalam bulan)
            $table->decimal('berat_badan', 5, 2); // BB dalam kg
            $table->decimal('tinggi_badan', 5, 2); // TB dalam cm
            $table->decimal('lingkar_kepala', 5, 2)->nullable(); // LK dalam cm
            $table->string('vitamin')->nullable();
            $table->enum('status_gizi', ['Sangat Kurang', 'Kurang', 'Baik', 'Lebih'])->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['pasien_id', 'tanggal_pemeriksaan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
