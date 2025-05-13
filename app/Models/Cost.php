<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $fillable = [ 'expense_id','amount','image_path', 'details', 'expense_type', 'order_id', 'date', 'user_id','customer_id','product_id','payment_method_id',];
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }


    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
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
