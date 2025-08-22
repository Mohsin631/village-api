<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RetailApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'full_name'   => $this->full_name,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'cv_url'      => url('storage/' . $this->cv_path),
            'linkedin'    => $this->linkedin_url,
            'cover_letter'=> $this->cover_letter,
            'lang'        => $this->lang,
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
