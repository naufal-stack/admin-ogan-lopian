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
        Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('wisata_id');
        $table->string('nama_wisata');
        $table->integer('pengunjung');
        $table->integer('qty_anak');
        $table->integer('qty_dewasa');
        $table->string('kordinat');
        $table->string('qrcode')->nullable();
        $table->date('tanggal');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
