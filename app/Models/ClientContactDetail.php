<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContactDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'phone',
        'fax',
        'email',
        'website',
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


    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
