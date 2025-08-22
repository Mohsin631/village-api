<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'job_title','department','location','type',
        'short_description','long_description',
        'status','sort_order'
    ];

    protected $casts = [
        'job_title' => 'array',
        'department' => 'array',
        'location' => 'array',
        'type' => 'array',
        'short_description' => 'array',
        'long_description' => 'array',
    ];

    public function t(array $map, string $lang): string
    {
        return $map[$lang] ?? $map['en'] ?? '';
    }
}
