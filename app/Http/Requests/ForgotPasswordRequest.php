<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
        /**
         * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Dapatkan aturan validasi yang berlaku untuk permintaan.
         *
         * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
         */
        public function rules(): array
        {
            return [
                'identifier' => 'required|string', // Bisa email atau nik_ktp
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
                'identifier.required' => 'Email atau NIK KTP wajib diisi.',
            ];
        }
}
