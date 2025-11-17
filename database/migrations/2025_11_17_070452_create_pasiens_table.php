<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir')->nullable();
            $table->text('alamat');
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('phone_ortu')->nullable();
            $table->foreignId('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->timestamps();

            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
