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
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('npsn')->unique(); // NPSN, harus unik
            $table->string('nama'); // Nama sekolah
            $table->string('alamat')->nullable(); // Alamat sekolah
            $table->string('desa')->nullable(); // Desa
            $table->string('kecamatan')->nullable(); // Kecamatan
            $table->string('jenjang')->nullable(); // Jenjang (SMP, SMA, SMK, dll.)
            $table->string('lat')->nullable(); // Latitude sebagai string
            $table->string('lng')->nullable(); // Longitude sebagai string
            $table->timestamps();
            $table->softDeletes(); // Untuk kolom deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
