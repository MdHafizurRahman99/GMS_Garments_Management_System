<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = ['name'];

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}

