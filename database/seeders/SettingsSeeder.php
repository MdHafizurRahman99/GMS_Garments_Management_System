<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\IncomeSource;
use App\Models\IncomeType;
use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Payment Methods
        $paymentMethods = [
            ['name' => 'Cash', 'type' => 'cash'],
            ['name' => 'Bank Transfer', 'type' => 'bank'],
            ['name' => 'Cheque', 'type' => 'cheque'],
            ['name' => 'Credit Card', 'type' => 'bank'],
            ['name' => 'Mobile Banking', 'type' => 'bank'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }

        // Income Sources
        $incomeSources = [
            ['name' => 'Sales Revenue'],
            ['name' => 'Owner Contribution'],
            ['name' => 'Investment'],
            ['name' => 'Loan'],
            ['name' => 'Other'],
        ];

        foreach ($incomeSources as $source) {
            IncomeSource::create($source);
        }

        // Income Types
        $incomeTypes = [
            ['name' => 'Sales'],
            ['name' => 'Investment'],
            ['name' => 'Loan'],
            ['name' => 'Other'],
        ];

        foreach ($incomeTypes as $type) {
            IncomeType::create($type);
        }

        // Expense Types
        $expenseTypes = [
            ['name' => 'Rent'],
            ['name' => 'Utilities'],
            ['name' => 'Supplies'],
            ['name' => 'Machinery Repair'],
            ['name' => 'Other'],
        ];

        foreach ($expenseTypes as $type) {
            ExpenseType::create($type);
        }
    }
}

