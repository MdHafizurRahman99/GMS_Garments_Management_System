<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $fillable = [ 'expense_id','amount','image_path', 'details', 'expense_type', 'order_id', 'date', 'user_id'];
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
