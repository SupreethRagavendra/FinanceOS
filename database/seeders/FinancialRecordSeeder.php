<?php

namespace Database\Seeders;

use App\Models\FinancialRecord;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FinancialRecordSeeder extends Seeder
{
    /**
     * Seed 35+ diverse financial records across multiple categories and months.
     */
    public function run(): void
    {
        $records = [
            // November 2025
            ['user_id' => 1, 'amount' => 85000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2025-11-01', 'notes' => 'Monthly salary - November'],
            ['user_id' => 1, 'amount' => 15000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2025-11-05', 'notes' => 'Office rent payment'],
            ['user_id' => 1, 'amount' => 3500.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2025-11-08', 'notes' => 'Groceries and dining'],
            ['user_id' => 2, 'amount' => 12000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2025-11-10', 'notes' => 'Freelance web dev project'],
            ['user_id' => 1, 'amount' => 25000.00, 'type' => 'expense', 'category' => 'Investment', 'date' => '2025-11-12', 'notes' => 'Mutual fund SIP'],
            ['user_id' => 1, 'amount' => 2200.00, 'type' => 'expense', 'category' => 'Utilities', 'date' => '2025-11-15', 'notes' => 'Electricity and water bill'],

            // December 2025
            ['user_id' => 1, 'amount' => 85000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2025-12-01', 'notes' => 'Monthly salary - December'],
            ['user_id' => 1, 'amount' => 15000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2025-12-05', 'notes' => 'Office rent payment'],
            ['user_id' => 2, 'amount' => 8000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2025-12-07', 'notes' => 'Logo design project'],
            ['user_id' => 1, 'amount' => 18000.00, 'type' => 'expense', 'category' => 'Shopping', 'date' => '2025-12-10', 'notes' => 'Holiday shopping'],
            ['user_id' => 1, 'amount' => 4200.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2025-12-15', 'notes' => 'Restaurant and groceries'],
            ['user_id' => 1, 'amount' => 25000.00, 'type' => 'expense', 'category' => 'Investment', 'date' => '2025-12-16', 'notes' => 'Mutual fund SIP'],

            // January 2026
            ['user_id' => 1, 'amount' => 90000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2026-01-01', 'notes' => 'Monthly salary - January (revised)'],
            ['user_id' => 1, 'amount' => 15000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2026-01-05', 'notes' => 'Office rent payment'],
            ['user_id' => 1, 'amount' => 5500.00, 'type' => 'expense', 'category' => 'Transport', 'date' => '2026-01-08', 'notes' => 'Fuel and cab expenses'],
            ['user_id' => 2, 'amount' => 15000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2026-01-10', 'notes' => 'Mobile app project milestone'],
            ['user_id' => 1, 'amount' => 3800.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2026-01-12', 'notes' => 'Monthly groceries'],
            ['user_id' => 1, 'amount' => 25000.00, 'type' => 'expense', 'category' => 'Investment', 'date' => '2026-01-15', 'notes' => 'Monthly SIP investment'],
            ['user_id' => 1, 'amount' => 8500.00, 'type' => 'expense', 'category' => 'Healthcare', 'date' => '2026-01-18', 'notes' => 'Annual health insurance premium'],

            // February 2026
            ['user_id' => 1, 'amount' => 90000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2026-02-01', 'notes' => 'Monthly salary - February'],
            ['user_id' => 1, 'amount' => 15000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2026-02-05', 'notes' => 'Office rent payment'],
            ['user_id' => 1, 'amount' => 7000.00, 'type' => 'expense', 'category' => 'Education', 'date' => '2026-02-08', 'notes' => 'Online course subscription'],
            ['user_id' => 2, 'amount' => 20000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2026-02-10', 'notes' => 'Website redesign final payment'],
            ['user_id' => 1, 'amount' => 4100.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2026-02-14', 'notes' => 'Valentines dinner + groceries'],
            ['user_id' => 1, 'amount' => 25000.00, 'type' => 'expense', 'category' => 'Investment', 'date' => '2026-02-15', 'notes' => 'Monthly SIP investment'],
            ['user_id' => 1, 'amount' => 2500.00, 'type' => 'expense', 'category' => 'Utilities', 'date' => '2026-02-18', 'notes' => 'Electricity and internet bill'],

            // March 2026
            ['user_id' => 1, 'amount' => 90000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2026-03-01', 'notes' => 'Monthly salary - March'],
            ['user_id' => 1, 'amount' => 50000.00, 'type' => 'income', 'category' => 'Bonus', 'date' => '2026-03-01', 'notes' => 'Annual performance bonus'],
            ['user_id' => 1, 'amount' => 15000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2026-03-05', 'notes' => 'Office rent payment'],
            ['user_id' => 1, 'amount' => 12000.00, 'type' => 'expense', 'category' => 'Shopping', 'date' => '2026-03-08', 'notes' => 'New laptop accessories'],
            ['user_id' => 2, 'amount' => 10000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2026-03-12', 'notes' => 'API integration project'],
            ['user_id' => 1, 'amount' => 3600.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2026-03-15', 'notes' => 'Monthly groceries and dining'],
            ['user_id' => 1, 'amount' => 25000.00, 'type' => 'expense', 'category' => 'Investment', 'date' => '2026-03-16', 'notes' => 'Monthly SIP investment'],
            ['user_id' => 1, 'amount' => 6000.00, 'type' => 'expense', 'category' => 'Transport', 'date' => '2026-03-20', 'notes' => 'Metro pass and cab rides'],

            // April 2026
            ['user_id' => 1, 'amount' => 90000.00, 'type' => 'income', 'category' => 'Salary', 'date' => '2026-04-01', 'notes' => 'Monthly salary - April'],
            ['user_id' => 1, 'amount' => 16000.00, 'type' => 'expense', 'category' => 'Rent', 'date' => '2026-04-03', 'notes' => 'Office rent (revised)'],
            ['user_id' => 2, 'amount' => 18000.00, 'type' => 'income', 'category' => 'Freelance', 'date' => '2026-04-02', 'notes' => 'Dashboard UI project'],
            ['user_id' => 1, 'amount' => 3200.00, 'type' => 'expense', 'category' => 'Food', 'date' => '2026-04-03', 'notes' => 'Weekly groceries'],
            ['user_id' => 1, 'amount' => 2800.00, 'type' => 'expense', 'category' => 'Utilities', 'date' => '2026-04-04', 'notes' => 'Internet and phone bills'],
        ];

        foreach ($records as $record) {
            FinancialRecord::create($record);
        }
    }
}
