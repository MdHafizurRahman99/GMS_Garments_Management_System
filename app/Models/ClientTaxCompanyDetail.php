<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTaxCompanyDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'tax_file_number',
        'business_number',
        'company_number',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
