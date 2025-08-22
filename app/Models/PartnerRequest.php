<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerRequest extends Model
{
    protected $fillable = [
        'company_name','contact_person','email','phone',
        'job_title','bank_name','bank_account','iban',
        'vat_registration_number','swift_code','location','services_summary',
        'lang','ip','user_agent',
    ];
}

