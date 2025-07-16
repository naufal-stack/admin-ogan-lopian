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
        Schema::create('wisatas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama tempat wisata
            $table->string('kategori')->nullable(); // Kategori wisata (misal: "Wisata")
            $table->longText('deskripsi')->nullable(); // Deskripsi wisata
            $table->longText('image')->nullable(); // Nama file gambar (jika disimpan sebagai path) atau Base64 (jika disimpan sebagai string panjang)
            $table->string('alamat')->nullable(); // Alamat
            $table->string('website')->nullable(); // Website
            $table->string('no_telp')->nullable(); // Nomor telepon
            $table->string('latitude')->nullable(); // Latitude
            $table->string('longitude')->nullable(); // Longitude
            $table->integer('prioritas')->default(0); // Prioritas
            $table->integer('checkout')->default(0); // Status checkout
            $table->string('jam_buka')->nullable(); // Jam buka
            $table->string('jam_tutup')->nullable(); // Jam tutup
            $table->decimal('child_price', 15, 2)->default(0); // Harga tiket anak
            $table->decimal('adult_price', 15, 2)->default(0); // Harga tiket dewasa
            $table->timestamps();
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisatas');
    }
};
