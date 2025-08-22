<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'company_name'     => $this->company_name,
            'contact_person'   => $this->contact_person,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'job_title'        => $this->job_title,
            'bank_name'        => $this->bank_name,
            'bank_account'     => $this->bank_account,
            'iban'             => $this->iban,
            'vat_number'       => $this->vat_registration_number,
            'swift_code'       => $this->swift_code,
            'location'         => $this->location,
            'services_summary' => $this->services_summary,
            'lang'             => $this->lang,
            'created_at'       => $this->created_at?->toIso8601String(),
        ];
    }
}
