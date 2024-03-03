<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusniessProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'company_type',
        'business_number',
        'company_number',
        'phone',
        'fax',
        'email',
        'mobile',
        'physical_street',
        'physical_city',
        'physical_state',
        'physical_postal_code',
        'physical_country',
        'postal_street',
        'postal_city',
        'postal_state',
        'postal_postal_code',
        'postal_country',
        'accountants_number',
        'software_name',
        'api_key',
    ];
}
