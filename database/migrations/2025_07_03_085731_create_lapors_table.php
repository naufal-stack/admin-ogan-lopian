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
        Schema::create('lapors', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable(); // ID Pengguna yang melaporkan
            $table->string('author')->nullable(); // Nama penulis/pelapor
            $table->string('judul'); // Judul laporan
            $table->longText('keterangan')->nullable(); // Keterangan/deskripsi laporan
            $table->string('status_laporan')->nullable(); // Status laporan (misal: "Pending", "Selesai", "Ditolak")
            $table->string('lat')->nullable(); // Latitude sebagai string
            $table->string('lng')->nullable(); // Longitude sebagai string
            $table->timestamp('report_time')->nullable(); // Waktu laporan
            $table->string('kategori')->nullable(); // Kategori laporan (misal: "Lain-Lain", "Kerusakan", "Saran")
            $table->timestamps();
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapors');
    }
};
