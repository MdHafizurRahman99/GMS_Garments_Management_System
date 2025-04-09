<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'amount',
        'income_source',
        'payment_method_id',
        'bank_name',
        'transaction_id',
        'details',
        'date',
        'user_id',
        'customer_id',
        'order_id',
        'image_path',
        'income_type'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }


    public function incomeSource()
    {
        return $this->belongsTo(IncomeSource::class);
    }

    public function incomeType()
    {
        return $this->belongsTo(IncomeType::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }

    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }
}

