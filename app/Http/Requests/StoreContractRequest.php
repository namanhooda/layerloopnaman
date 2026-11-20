<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'contract_type_id' => ['required','exists:contract_types,id'],
            'contract_template_id' => ['nullable','exists:contract_templates,id'],
            'title' => ['required','string','max:255'],
            'business_unit' => ['required','string','max:80'],
            'party_type' => ['required','in:individual,company,seller,franchise,other'],
            'party_name' => ['required','string','max:255'],
            'company_name' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'phone' => ['nullable','string','max:40'],
            'address' => ['nullable','string'],
            'city' => ['nullable','string','max:120'],
            'state' => ['nullable','string','max:120'],
            'country' => ['nullable','string','max:120'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after_or_equal:start_date'],
            'territory_type' => ['nullable','in:global,country,state,city,district,custom'],
            'territory_details' => ['nullable','array'],
            'is_exclusive' => ['nullable','boolean'],
            'payment_amount' => ['nullable','numeric','min:0'],
            'payment_type' => ['nullable','in:fixed,royalty,percentage,none'],
            'payment_terms' => ['nullable','string'],
            'description' => ['nullable','string'],
            'scope_of_work' => ['nullable','string'],
            'special_restrictions' => ['nullable','string'],
            'internal_notes' => ['nullable','string'],
            'products' => ['nullable','array'],
            'products.*.product_id' => ['nullable','integer'],
            'products.*.product_name' => ['required_with:products','string','max:255'],
            'products.*.product_code' => ['nullable','string','max:120'],
            'products.*.stl_file_name' => ['nullable','string','max:255'],
            'products.*.restriction_type' => ['required_with:products','in:exclusive,protected,licensed,prohibited'],
            'products.*.remarks' => ['nullable','string'],
            'conditions' => ['nullable','array'],
            'conditions.*.condition_title' => ['required_with:conditions','string','max:255'],
            'conditions.*.condition_description' => ['required_with:conditions','string'],
            'conditions.*.condition_type' => ['nullable','string','max:80'],
            'conditions.*.is_mandatory' => ['nullable','boolean'],
        ];
    }
}
