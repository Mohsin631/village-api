<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'full_name','email','phone','inquiry_type_id','message','lang','ip','user_agent'
    ];
    public function inquiryType() { return $this->belongsTo(InquiryType::class); }
}
