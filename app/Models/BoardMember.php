<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardMember extends Model
{
    protected $fillable = ['name','position','image','is_active','sort_order'];
    protected $casts = ['name'=>'array','position'=>'array','is_active'=>'boolean'];

    public function label(array $map, string $lang): string
    {
        return $map[$lang] ?? $map['en'] ?? '';
    }

    public function nameFor(string $lang): string
    {
        return $this->label($this->name ?? [], $lang);
    }

    public function positionFor(string $lang): string
    {
        return $this->label($this->position ?? [], $lang);
    }
}
