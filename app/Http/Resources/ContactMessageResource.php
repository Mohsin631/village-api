<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'full_name'  => $this->full_name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'inquiry'    => $this->when($this->inquiryType, [
                'id'    => $this->inquiryType->id,
                'slug'  => $this->inquiryType->slug,
                'label' => $this->inquiryType->label($this->lang ?? 'en'),
            ]),
            'message'    => $this->message,
            'lang'       => $this->lang,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}

