<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryType extends Model
{
    protected $fillable = ['slug','name','is_active'];
    protected $casts = ['name' => 'array', 'is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function label(string $lang = 'en'): string {
        $name = $this->name ?? [];
        return $name[$lang] ?? $name['en'] ?? $this->slug;
    }
}
