<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name'       => ['required','string','max:150'],
            'email'           => ['required','email:rfc,dns','max:191'],
            'phone'           => ['required','string','max:32'],
            'inquiry_type_id' => ['nullable','integer','exists:inquiry_types,id'],
            'message'         => ['nullable','string','max:2000'],
        ];
    }
}

