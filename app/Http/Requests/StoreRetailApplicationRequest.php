<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRetailApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['required','string','max:191'],
            'email'     => ['required','email:rfc','max:191'],
            'phone'     => ['required','string','max:50'],

            'cv' => ['required','file','mimes:pdf,doc,docx,jpg,jpeg,png','max:10120'],
            'linkedin_url' => ['nullable','url'],
            'cover_letter' => ['nullable','string','max:5000'],
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
