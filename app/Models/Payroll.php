<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'gross_pay',
        'net_pay',
        'deductions',
        'payment_date',
    ];

    protected $casts = [
        'pay_period_start' => 'date',
        'pay_period_end' => 'date',
        'payment_date' => 'date',
    ];
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
