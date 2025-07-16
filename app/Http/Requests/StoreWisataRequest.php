<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWisataRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        // Sesuaikan ini dengan logika otorisasi Anda,
        // misalnya, apakah pengguna yang login adalah admin.
        return true; // Untuk tujuan pengembangan, kita set true dulu
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255', // Menggunakan 'nama'
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Menggunakan 'image', opsional saat membuat, max 2MB
            'alamat' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'prioritas' => 'nullable|integer',
            'checkout' => 'nullable|boolean',
            'jam_buka' => 'nullable|string|max:255',
            'jam_tutup' => 'nullable|string|max:255',
            'child_price' => 'nullable|numeric',
            'kuota' => 'required|integer|min:0',
            'adult_price' => 'nullable|numeric',
        ];
    }

    /**
     * Dapatkan pesan kesalahan validasi yang ditentukan untuk aturan yang ditentukan.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wisata wajib diisi.',
            'nama.string' => 'Nama wisata harus berupa teks.',
            'nama.max' => 'Nama wisata tidak boleh lebih dari 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            // Tambahkan pesan kustom lainnya sesuai kebutuhan
        ];
    }
}
