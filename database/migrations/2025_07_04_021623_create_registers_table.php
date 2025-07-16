<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Username, harus unik
            $table->string('email')->unique(); // Email, harus unik
            $table->string('nama_lengkap'); // Nama lengkap pengguna
            $table->string('nik_ktp')->unique(); // Tambahkan NIK KTP, harus unik
            $table->string('password'); // Password (akan di-hash)
            $table->string('activation_key')->nullable(); // Kunci aktivasi
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
