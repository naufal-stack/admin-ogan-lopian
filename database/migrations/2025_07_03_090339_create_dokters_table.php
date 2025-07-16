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
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable(); // ID User yang terkait
            $table->string('nomor_str')->unique()->nullable(); // Nomor STR, harus unik
            $table->string('nama'); // Nama dokter
            $table->string('username')->unique(); // Username, harus unik
            $table->string('password'); // Password
            $table->string('keahlian')->nullable(); // Keahlian dokter (misal: Dokter Umum)
            $table->string('handphone')->nullable(); // Nomor handphone
            $table->string('unit_kerja')->nullable(); // Unit kerja
            $table->integer('pengalaman')->default(0); // Pengalaman dalam tahun
            $table->longText('foto')->nullable(); // Nama file foto atau Base64
            $table->string('device_token', 500)->nullable(); // Device token untuk notifikasi
            $table->timestamp('last_update')->nullable(); // Waktu terakhir update
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
