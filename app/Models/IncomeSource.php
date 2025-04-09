<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    protected $fillable = ['name'];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}

