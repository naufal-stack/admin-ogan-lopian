<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Register; // Pastikan model Register diimport
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Support\Str; // Untuk menghasilkan activation_key
use Illuminate\Support\Facades\Validator; // Untuk validasi input

class CreateAdminUser extends Command
{
    /**
     * Nama dan tanda tangan perintah konsol.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Membuat akun pengguna admin baru.';

    /**
     * Jalankan perintah konsol.
     */
    public function handle()
    {
        $this->info('Membuat akun admin baru...');

        // Minta input dari pengguna
        $username = $this->ask('Masukkan Username admin:');
        $email = $this->ask('Masukkan Email admin:');
        $namaLengkap = $this->ask('Masukkan Nama Lengkap admin:');
        $nikKtp = $this->ask('Masukkan NIK KTP admin (16 digit):');
        $password = $this->secret('Masukkan Password admin:'); // Menggunakan secret untuk menyembunyikan input password
        $passwordConfirmation = $this->secret('Konfirmasi Password admin:');

        // Validasi input
        $validator = Validator::make([
            'username' => $username,
            'email' => $email,
            'nama_lengkap' => $namaLengkap,
            'nik_ktp' => $nikKtp,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'username' => ['required', 'string', 'max:255', 'unique:registers,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:registers,email'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik_ktp' => ['required', 'string', 'digits:16', 'unique:registers,nik_ktp'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik_ktp.required' => 'NIK KTP wajib diisi.',
            'nik_ktp.digits' => 'NIK KTP harus 16 digit.',
            'nik_ktp.unique' => 'NIK KTP ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            $this->error('Gagal membuat akun admin karena kesalahan validasi:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        // Buat akun admin
        try {
            $admin = Register::create([
                'username' => $username,
                'email' => $email,
                'nama_lengkap' => $namaLengkap,
                'nik_ktp' => $nikKtp,
                'password' => Hash::make($password), // Hash password
                'role' => 'admin', // Set role menjadi 'admin'
                'activation_key' => Str::random(32), // Tetap buat key meskipun langsung verified
                'verified_at' => now(), // Langsung verifikasi akun admin
            ]);

            $this->info("Akun admin '{$admin->username}' berhasil dibuat!");
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $admin->id],
                    ['Username', $admin->username],
                    ['Email', $admin->email],
                    ['Role', $admin->role],
                    ['Status Verifikasi', $admin->verified_at ? 'Terverifikasi' : 'Belum Terverifikasi'],
                ]
            );
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan saat membuat akun admin: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
