<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'nik_ktp' => 'required|string|digits:16', // Menggunakan nik_ktp sebagai identifier
            'password' => 'required|string',
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
            'nik_ktp.required' => 'Nomor NIK KTP wajib diisi.',
            'nik_ktp.digits' => 'Nomor NIK KTP harus terdiri dari 16 digit.',
            'password.required' => 'Password wajib diisi.',
        ];
    }
}
