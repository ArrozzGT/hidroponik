<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'no_hp' => ['required', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            // Farmer profile fields (only if role is petani)
            'nama_kebun' => ['nullable', 'required_if:role,petani', 'string', 'max:255'],
            'lokasi_kebun' => ['nullable', 'required_if:role,petani', 'string', 'max:255'],
            'deskripsi_kebun' => ['nullable', 'string'],
        ];
    }
}
