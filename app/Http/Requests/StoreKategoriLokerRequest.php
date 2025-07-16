<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriLokerRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:kategori_lokers,name', // Nama kategori wajib, string, max 255, dan unik
            // Kolom 'total' tidak ada di sini karena dihitung secara dinamis.
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
            'name.unique' => 'Nama kategori ini sudah ada.',
        ];
    }
}
