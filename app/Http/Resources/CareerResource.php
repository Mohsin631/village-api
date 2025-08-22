<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        return [
            'id'                 => $this->id,
            'job_title'          => $this->t($this->job_title ?? [], $lang),
            'department'         => $this->t($this->department ?? [], $lang),
            'location'           => $this->t($this->location ?? [], $lang),
            'type'               => $this->t($this->type ?? [], $lang),
            'short_description'  => $this->t($this->short_description ?? [], $lang),
            'long_description'   => $this->t($this->long_description ?? [], $lang),
            'status'             => $this->status,
            'created_at'         => $this->created_at?->toIso8601String(),
        ];
    }
}
