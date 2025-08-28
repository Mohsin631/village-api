<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = ['name','name_ar'];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function getTranslatedName($lang = 'en')
    {
        return $lang === 'ar' ? $this->name_ar : $this->name;
    }
}

