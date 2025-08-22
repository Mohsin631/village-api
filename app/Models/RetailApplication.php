<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetailApplication extends Model
{
    protected $fillable = [
        'career_id', 'full_name','email','phone','cv_path',
        'linkedin_url','cover_letter','lang','ip','user_agent'
    ];

    public function career() { return $this->belongsTo(\App\Models\Career::class); }
}
