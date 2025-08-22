<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePartnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_name' => ['required','string','max:191'],
            'contact_person' => ['required','string','max:150'],
            'email' => ['required','email:rfc','max:191'],
            'phone' => ['required','string','max:50'],
            'job_title' => ['nullable','string','max:150'],
            'bank_name' => ['nullable','string','max:191'],
            'bank_account' => ['nullable','string','max:191'],
            'iban' => ['nullable','string','max:191'],
            'vat_registration_number' => ['nullable','string','max:100'],
            'swift_code' => ['nullable','string','max:50'],
            'location' => ['nullable','string','max:191'],
            'services_summary' => ['nullable','string','max:5000'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
