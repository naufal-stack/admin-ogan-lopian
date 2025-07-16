<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporRequest extends FormRequest
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
            'id_user' => 'nullable|string|max:255', // ID Pengguna bisa string atau integer tergantung implementasi user ID Anda
            'author' => 'nullable|string|max:255',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status_laporan' => 'nullable|string|max:50',
            'lat' => 'nullable|string|max:50', // Latitude sebagai string
            'lng' => 'nullable|string|max:50', // Longitude sebagai string
            'report_time' => 'nullable|date', // Waktu laporan, harus format tanggal/waktu yang valid
            'kategori' => 'nullable|string|max:255',
        ];
    }
}
