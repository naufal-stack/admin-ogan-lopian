<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Mengubah nama tabel dari 'password_reset_tokens' menjadi 'password_resets'
        // untuk mengatasi error 'Table 'password_resets' doesn't exist'.
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index(); // Menggunakan index() daripada primary()
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
