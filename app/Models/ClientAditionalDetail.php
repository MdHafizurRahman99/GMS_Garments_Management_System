<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAditionalDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'activity_statement',
        'tax_form',
        'ato_client',
        'verification_document',
        'document_type',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}