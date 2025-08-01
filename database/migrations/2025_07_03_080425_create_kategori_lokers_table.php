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
        Schema::create('kategori_lokers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama kategori, harus unik
            // Kolom 'total' akan dihitung secara dinamis, tidak disimpan di sini.
            $table->timestamps();
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_lokers');
    }
};
