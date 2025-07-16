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
        Schema::create('informasi_pentings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable(); // Tambahkan kolom id_user
            $table->string('name'); // Mengganti 'nama' menjadi 'name'
            $table->longText('content')->nullable(); // Mengganti 'deskripsi' menjadi 'content'
            $table->longText('image')->nullable(); // Tetap longText untuk Base64
            // Kolom-kolom seperti kategori, alamat, website, no_telp, latitude, longitude, jam_buka, jam_tutup
            // tidak ada di respons yang Anda inginkan, jadi saya tidak memasukkannya di sini.
            $table->timestamps(); // Untuk created_at dan updated_at
            $table->softDeletes(); // Untuk deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_pentings');
    }
};
