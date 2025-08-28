<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title','title_ar',
        'short_description','short_description_ar',
        'long_description','long_description_ar',
        'cover_image','blog_category_id','status'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function translate($lang = 'en')
    {
        return [
            'id' => $this->id,
            'title' => $lang === 'ar' ? $this->title_ar : $this->title,
            'short_description' => $lang === 'ar' ? $this->short_description_ar : $this->short_description,
            'long_description' => $lang === 'ar' ? $this->long_description_ar : $this->long_description,
            'cover_image' => env('APP_URL').$this->cover_image,
            'status' => $this->status,
            
            'category' => $this->category ? [
                'id'   => $this->category->id,
                'name' => $this->category->getTranslatedName($lang),
            ] : null,
    
            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
    
}
