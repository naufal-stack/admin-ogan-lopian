<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true; // Ubah menjadi true agar request ini bisa diakses
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255|unique:registers,username', // Username wajib, unik
            'email' => 'required|string|email|max:255|unique:registers,email', // Email wajib, format email, unik
            'nama_lengkap' => 'required|string|max:255',
            'nik_ktp' => 'required|string|digits:16|unique:registers,nik_ktp', // NIK KTP wajib, 16 digit, unik
            'password' => 'required|string|min:6|confirmed', // Password wajib, minimal 6 karakter, harus ada konfirmasi password
            'password_confirmation' => 'required|string|min:6', // Konfirmasi password wajib
        ];
    }

    /**
     * Dapatkan pesan kesalahan kustom untuk aturan validasi yang ditentukan.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.unique' => 'Username ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'nik_ktp.required' => 'Nomor NIK KTP wajib diisi.',
            'nik_ktp.digits' => 'Nomor NIK KTP harus terdiri dari 16 digit.',
            'nik_ktp.unique' => 'Nomor NIK KTP ini sudah terdaftar.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
