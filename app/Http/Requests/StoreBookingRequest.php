<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        // Pastikan pengguna sudah terotentikasi untuk membuat pemesanan
        return auth()->check();
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wisata_id' => ['required', 'exists:wisatas,id'], // Pastikan wisata_id ada dan valid
            'qty_anak' => ['required', 'integer', 'min:0'],
            'qty_dewasa' => ['required', 'integer', 'min:0'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'], // Tanggal pemesanan tidak boleh di masa lalu
        ];
    }

    /**
     * Dapatkan pesan kesalahan untuk aturan validasi yang ditentukan.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'wisata_id.required' => 'ID wisata wajib diisi.',
            'wisata_id.exists' => 'Wisata tidak ditemukan.',
            'qty_anak.required' => 'Jumlah tiket anak wajib diisi.',
            'qty_anak.integer' => 'Jumlah tiket anak harus berupa angka.',
            'qty_anak.min' => 'Jumlah tiket anak minimal 0.',
            'qty_dewasa.required' => 'Jumlah tiket dewasa wajib diisi.',
            'qty_dewasa.integer' => 'Jumlah tiket dewasa harus berupa angka.',
            'qty_dewasa.min' => 'Jumlah tiket dewasa minimal 0.',
            'tanggal.required' => 'Tanggal pemesanan wajib diisi.',
            'tanggal.date' => 'Format tanggal pemesanan tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal pemesanan tidak boleh di masa lalu.',
        ];
    }

    /**
     * Siapkan data untuk validasi.
     * Ini berguna jika Anda perlu memanipulasi input sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        // Pastikan setidaknya satu tiket (anak atau dewasa) dipesan
        if ($this->qty_anak === 0 && $this->qty_dewasa === 0) {
            $this->merge([
                'qty_anak' => 1, // Set default agar validasi min:0 tidak gagal, lalu tambahkan custom rule jika perlu
            ]);
        }
    }

    /**
     * Tambahkan aturan validasi kustom.
     * Pastikan total tiket (anak + dewasa) minimal 1.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (($this->qty_anak + $this->qty_dewasa) <= 0) {
                $validator->errors()->add('quantity', 'Setidaknya satu tiket (anak atau dewasa) harus dipesan.');
            }
        });
    }
}
