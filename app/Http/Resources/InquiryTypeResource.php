<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InquiryTypeResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        return [
            'id'    => $this->id,
            'slug'  => $this->slug,
            'label' => $this->label($lang),
        ];
    }
}

