<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name', 'type', 'is_active'];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}

