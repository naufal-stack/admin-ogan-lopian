<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSekolahRequest extends FormRequest
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
            'npsn' => 'required|string|max:20|unique:sekolahs,npsn', // NPSN wajib, string, max 20, dan unik
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'jenjang' => 'nullable|string|max:50', // Jenjang (SMP, SMA, SMK, dll.)
            'lat' => 'nullable|string|max:50', // Latitude sebagai string
            'lng' => 'nullable|string|max:50', // Longitude sebagai string
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
            'npsn.unique' => 'NPSN ini sudah terdaftar.',
        ];
    }
}
