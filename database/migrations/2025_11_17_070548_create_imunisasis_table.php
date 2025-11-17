<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imunisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('jenis_imunisasi'); // BCG, Polio, DPT, Campak, dll
            $table->date('tanggal_imunisasi');
            $table->integer('usia_bulan_saat_imunisasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('pasien_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imunisasis');
    }
};
