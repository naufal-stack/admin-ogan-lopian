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
        Schema::table('registers', function (Blueprint $table) {
            $table->string('telepon')->nullable()->after('nama_lengkap'); // Tambahkan kolom telepon
            $table->date('tgl_lahir')->nullable()->after('telepon'); // Tambahkan kolom tgl_lahir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registers', function (Blueprint $table) {
            $table->dropColumn('telepon');
            $table->dropColumn('tgl_lahir');
        });
    }
};
