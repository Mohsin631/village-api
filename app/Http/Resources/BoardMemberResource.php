<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardMemberResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = strtolower($request->query('lang', $request->header('Accept-Language', 'en')));
        $lang = in_array($lang, ['en','ar']) ? $lang : 'en';

        return [
            'id'       => $this->id,
            'name'     => $this->nameFor($lang),
            'position' => $this->positionFor($lang),
            'image'    => env('APP_URL').$this->image,
        ];
    }
}

