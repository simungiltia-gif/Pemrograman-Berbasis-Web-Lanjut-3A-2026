<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $anggotaId = optional($this->user()->anggota)->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
                Rule::unique('anggotas', 'email')->ignore($anggotaId),
            ],
            'no_telepon' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'no_telepon' => 'nomor telepon',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, +, - dan tanda kurung.',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
        ];
    }
}
