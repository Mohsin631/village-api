<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'is_public'];
    protected $casts = ['value' => 'array', 'is_public' => 'boolean'];

    public function scopePublic($q) { return $q->where('is_public', true); }

    public static function getValue(string $key, $default = [])
    {
        return optional(static::public()->where('key', $key)->first())->value ?? $default;
    }
}
