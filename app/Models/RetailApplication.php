<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetailApplication extends Model
{
    protected $fillable = [
        'full_name', 'email', 'phone', 'cv_path',
        'linkedin_url', 'cover_letter',
        'lang', 'ip', 'user_agent'
    ];
}
