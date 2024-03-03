<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBankDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'account_name',
        'account_number',
        'financial_institution_name',
        'bsb_number',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
