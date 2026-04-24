<?php

namespace App\Console\Commands;

use App\Models\StudentAttendance;
use App\Services\SmsService;
use Illuminate\Console\Command;

class SendDailyAttendanceSms extends Command
{
    protected $signature = 'attendance:send-alerts {--date= : Date in YYYY-MM-DD format}';
    protected $description = 'Send SMS alerts to parents of students marked absent';

    public function handle(SmsService $smsService)
    {
        $date = $this->option('date') ?: now()->format('Y-m-d');
        $this->info("Processing attendance alerts for: " . $date);

        // Get all students marked absent for the given date
        $absentees = StudentAttendance::with(['student.user', 'student.parent'])
            ->where('attendance_date', $date)
            ->where('status', 'absent')
            ->get();

        $count = 0;
        foreach ($absentees as $attendance) {
            $student = $attendance->student;
            $parent = $student->parent;
            
            // Determine phone number to send to (Guardian > Father > Mother)
            $phone = $parent->guardian_phone ?: ($parent->father_phone ?: $parent->mother_phone);

            if ($phone) {
                $message = "Attendance Alert: Your child {$student->user->name} is absent from school today ({$date}).";
                
                $sent = $smsService->send($phone, $message, $student->campus_id);
                
                if ($sent) {
                    $count++;
                }
            }
        }

        $this->info("Successfully sent {$count} absence alerts.");
    }
}
