<?php

namespace App\Console\Commands;

use App\Models\FeeInvoice;
use App\Models\FeeStructure;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateMonthlyFees extends Command
{
    protected $signature = 'fees:generate {--month= : Month in YYYY-MM format}';
    protected $description = 'Automatically generate fee invoices for students based on class fee structures';

    public function handle()
    {
        $monthStr = $this->option('month') ?: now()->format('Y-m-01');
        $billingMonth = Carbon::parse($monthStr)->startOfMonth();
        
        $this->info("Generating fees for: " . $billingMonth->format('F Y'));

        // Get all active students
        $students = Student::where('status', 'active')->get();
        $count = 0;

        foreach ($students as $student) {
            // Find fee structures for this student's class
            $structures = FeeStructure::where('school_class_id', $student->school_class_id)
                ->where('campus_id', $student->campus_id)
                ->get();

            foreach ($structures as $structure) {
                // Check if invoice already exists to prevent duplicates
                $exists = FeeInvoice::where('student_id', $student->id)
                    ->where('fee_type_id', $structure->fee_type_id)
                    ->where('billing_month', $billingMonth->format('Y-m-d'))
                    ->exists();

                if (!$exists) {
                    $dueDate = $billingMonth->copy()->day($structure->due_day ?: 10);
                    
                    FeeInvoice::create([
                        'campus_id' => $student->campus_id,
                        'student_id' => $student->id,
                        'academic_year_id' => $student->academic_year_id,
                        'fee_type_id' => $structure->fee_type_id,
                        'billing_month' => $billingMonth->format('Y-m-d'),
                        'amount' => $structure->amount,
                        'net_amount' => $structure->amount,
                        'balance_amount' => $structure->amount,
                        'due_date' => $dueDate->format('Y-m-d'),
                        'status' => 'unpaid',
                        'challan_no' => 'CH-' . strtoupper(Str::random(8)),
                    ]);
                    $count++;
                }
            }
        }

        $this->info("Successfully generated {$count} invoices.");
    }
}
