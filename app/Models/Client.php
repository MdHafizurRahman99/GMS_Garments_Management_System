<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'id',
        'user_id',
        'business_structure',
        'client_type',
        'full_legal_name',
        'status',
    ];


    public function additionalDetails()
    {
        return $this->hasOne(ClientAditionalDetail::class, 'client_id');
    }

    // Relationship with client_bank_details table
    public function bankDetails()
    {
        return $this->hasOne(ClientBankDetail::class, 'client_id');
    }

    // Relationship with client_contact_details table
    public function contactDetails()
    {
        return $this->hasOne(ClientContactDetail::class, 'client_id');
    }

    // Relationship with client_tax_company_details table
    public function taxCompanyDetails()
    {
        return $this->hasOne(ClientTaxCompanyDetail::class, 'client_id');
    }
}
