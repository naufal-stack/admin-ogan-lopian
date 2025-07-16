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
        Schema::create('lokers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable(); // New: id_kategori
            $table->string('posisi'); // New: posisi
            $table->longText('deskripsi')->nullable(); // New: deskripsi (using longText for job description)
            $table->string('perusahaan'); // New: perusahaan
            $table->longText('logo')->nullable(); // New: logo (longText for Base64 image)
            $table->string('pendidikan')->nullable(); // New: pendidikan
            $table->string('lokasi')->nullable(); // New: lokasi
            $table->string('tipe_pekerjaan')->nullable(); // New: tipe_pekerjaan
            $table->string('level_pekerjaan')->nullable(); // New: level_pekerjaan
            $table->string('kategori')->nullable(); // New: kategori (for job category)
            $table->string('website')->nullable(); // New: website
            $table->decimal('salary_from', 15, 2)->default(0); // New: salary_from (decimal for currency)
            $table->decimal('salary_to', 15, 2)->default(0); // New: salary_to (decimal for currency)
            $table->timestamps();
            $table->softDeletes(); // Untuk deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokers');
    }
};
