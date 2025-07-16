<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
                'token' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
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
                'token.required' => 'Token reset password wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password baru minimal harus :min karakter.',
                'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            ];
        }
}
