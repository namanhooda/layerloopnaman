<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePartyRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'party_type' => ['required', Rule::in(['customer', 'vendor', 'employee', 'other'])],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:3000'],
            'partyable_type' => ['nullable', 'string', Rule::in(config('advance-payments.partyable_models', []))],
            'partyable_id' => ['nullable', 'integer', 'required_with:partyable_type'],
        ];
    }
}
