<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'kader'])->default('kader')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandus')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['role', 'phone', 'posyandu_id']);
        });
    }
};
