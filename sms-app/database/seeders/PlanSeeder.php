<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'max_branches' => 1,
                'monthly_price' => 49.99,
                'features' => [
                    'Student Management',
                    'Attendance Tracking',
                    'Basic Reporting',
                    'Email Notifications'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Professional Plan',
                'max_branches' => 5,
                'monthly_price' => 149.99,
                'features' => [
                    'Everything in Basic',
                    'Fee Management',
                    'Exam Management',
                    'SMS Notifications',
                    'Inventory Management'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise Plan',
                'max_branches' => 20,
                'monthly_price' => 399.99,
                'features' => [
                    'Everything in Professional',
                    'Payroll Management',
                    'Library Management',
                    'Transport Management',
                    'Custom Domain Support',
                    'Priority Support'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(
                ['name' => $planData['name']],
                $planData
            );
        }
    }
}
