<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|string',
            'alamat' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'jam_buka' => 'nullable|string|max:20',
            'jam_tutup' => 'nullable|string|max:20',
        ];
    }
}
