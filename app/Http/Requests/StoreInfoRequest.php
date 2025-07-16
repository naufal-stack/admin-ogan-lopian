<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfoRequest extends FormRequest
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
            'id_user' => 'nullable|integer', // id_user bisa null atau integer
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|string', // Tetap string untuk Base64
            // Kolom lain dari Hotel tidak diperlukan di sini
        ];
    }
}
