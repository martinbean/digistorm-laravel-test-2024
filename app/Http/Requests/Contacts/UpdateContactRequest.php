<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['filled', 'string', 'max:50'],
            'last_name' => ['filled', 'string', 'max:50'],
            'DOB' => ['filled', 'string', 'date_format:Y-m-d'],
            'company_name' => ['filled', 'string', 'max:100'],
            'position' => ['filled', 'string', 'max:100'],
            'email' => ['filled', 'string', 'max:255', 'email'],
            'number' => ['array'],
            'number.*' => ['nullable', 'string', 'max:15', 'distinct'],
        ];
    }
}
