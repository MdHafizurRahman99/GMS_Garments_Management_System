<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            ['name' => 'Cash', 'type' => 'cash'],
            ['name' => 'Bank Transfer', 'type' => 'bank'],
            ['name' => 'Cheque', 'type' => 'cheque'],
            ['name' => 'Credit Card', 'type' => 'bank'],
            ['name' => 'Mobile Banking', 'type' => 'bank'],
        ];

        // Loop through each payment method and create the record
        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
