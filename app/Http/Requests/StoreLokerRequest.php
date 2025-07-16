<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLokerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_user' => 'nullable|integer',
            'id_kategori' => 'nullable|integer',
            'posisi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'perusahaan' => 'required|string|max:255',
            'logo' => 'nullable|string', // Tetap string untuk Base64
            'pendidikan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tipe_pekerjaan' => 'nullable|string|max:255',
            'level_pekerjaan' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255', // Kategori untuk Loker
            'website' => 'nullable|string|max:255',
            'salary_from' => 'nullable|numeric',
            'salary_to' => 'nullable|numeric|gte:salary_from', // salary_to harus lebih besar atau sama dengan salary_from
        ];
    }
}
