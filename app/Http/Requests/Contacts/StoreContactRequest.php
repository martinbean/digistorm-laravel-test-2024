<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'DOB' => ['nullable', 'string', 'date_format:Y-m-d'],
            'company_name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'string', 'max:255', 'email'],
            'number' => ['required', 'array', 'min:1'],
            'number.*' => ['string', 'max:15', 'distinct'],
        ];
    }
}
