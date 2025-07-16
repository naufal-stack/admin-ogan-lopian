<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah menjadi true agar request ini bisa diakses
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_user' => 'nullable|string|max:255',
            'nomor_str' => 'nullable|string|max:255|unique:dokters,nomor_str', // Nomor STR unik
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:dokters,username', // Username unik
            'password' => 'required|string|min:6', // Password minimal 6 karakter
            'keahlian' => 'nullable|string|max:255',
            'handphone' => 'nullable|string|max:20',
            'unit_kerja' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|integer|min:0',
            'foto' => 'nullable|string', // String untuk Base64 atau nama file
            'device_token' => 'nullable|string|max:500',
            'last_update' => 'nullable|date', // Waktu terakhir update
        ];
    }

    /**
     * Get custom error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nomor_str.unique' => 'Nomor STR ini sudah terdaftar.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Password minimal harus :min karakter.',
        ];
    }
}
