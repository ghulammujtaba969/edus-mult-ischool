<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Enums\ExamStatus;
use App\Enums\InvoiceStatus;
use App\Enums\StudentStatus;
use App\Enums\UserRole;
use App\Models\AcademicYear;
use App\Models\ActivityLog;
use App\Models\Campus;
use App\Models\Employee;
use App\Models\Exam;
use App\Models\ExamType;
use App\Models\FeeInvoice;
use App\Models\FeePayment;
use App\Models\FeeType;
use App\Models\Mark;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAcademicRecord;
use App\Models\StudentAttendance;
use App\Models\StudentParent;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSchoolSeeder extends Seeder
{
    public function run(): void
    {
        $islamabad = Campus::create([
            'name' => 'Al-Falah School System - Islamabad Campus',
            'code' => 'AFS-ISB',
            'phone' => '051-2345678',
            'email' => 'isb@alfalah.edu.pk',
            'address' => 'G-11 Markaz, Islamabad',
            'city' => 'Islamabad',
        ]);

        $lahore = Campus::create([
            'name' => 'Al-Falah School System - Lahore Campus',
            'code' => 'AFS-LHE',
            'phone' => '042-3456789',
            'email' => 'lhr@alfalah.edu.pk',
            'address' => 'Johar Town, Lahore',
            'city' => 'Lahore',
        ]);

        $superAdmin = User::create([
            'name' => 'Muhammad Asif',
            'email' => 'superadmin@educore.test',
            'phone' => '0300-1111111',
            'role' => UserRole::SUPER_ADMIN,
            'password' => Hash::make('password'),
        ]);

        $campusAdmin = User::create([
            'campus_id' => $islamabad->id,
            'name' => 'Muhammad Asif',
            'email' => 'admin@alfalah.edu.pk',
            'phone' => '0312-3456789',
            'role' => UserRole::CAMPUS_ADMIN,
            'password' => Hash::make('password'),
        ]);

        $teacherUser = User::create([
            'campus_id' => $islamabad->id,
            'name' => 'Bilal Ahmed',
            'email' => 'teacher@alfalah.edu.pk',
            'phone' => '0311-1234567',
            'role' => UserRole::TEACHER,
            'password' => Hash::make('password'),
        ]);

        Employee::create([
            'campus_id' => $islamabad->id,
            'user_id' => $campusAdmin->id,
            'employee_code' => 'EMP-001',
            'designation' => 'Campus Admin',
            'department' => 'Administration',
            'joining_date' => '2022-08-01',
            'phone' => $campusAdmin->phone,
            'status' => 'active',
        ]);

        Employee::create([
            'campus_id' => $islamabad->id,
            'user_id' => $teacherUser->id,
            'employee_code' => 'EMP-002',
            'designation' => 'Senior Teacher',
            'department' => 'Science',
            'joining_date' => '2021-03-01',
            'phone' => $teacherUser->phone,
            'status' => 'active',
        ]);

        $year = AcademicYear::create([
            'campus_id' => $islamabad->id,
            'name' => '2025-2026',
            'start_date' => '2025-04-01',
            'end_date' => '2026-03-31',
            'is_current' => true,
        ]);

        Term::create([
            'campus_id' => $islamabad->id,
            'academic_year_id' => $year->id,
            'name' => 'Mid Term',
            'start_date' => '2025-09-01',
            'end_date' => '2025-11-15',
        ]);

        $classes = collect([
            ['name' => 'Class 6', 'level' => 'Middle', 'order_seq' => 6],
            ['name' => 'Class 7', 'level' => 'Middle', 'order_seq' => 7],
            ['name' => 'Class 8', 'level' => 'Middle', 'order_seq' => 8],
            ['name' => 'Class 9', 'level' => 'Secondary', 'order_seq' => 9],
            ['name' => 'Class 10', 'level' => 'Secondary', 'order_seq' => 10],
        ])->map(fn (array $data) => SchoolClass::create(['campus_id' => $islamabad->id] + $data))->keyBy('name');

        $sections = collect([
            ['class' => 'Class 6', 'name' => 'A'],
            ['class' => 'Class 6', 'name' => 'B'],
            ['class' => 'Class 7', 'name' => 'A'],
            ['class' => 'Class 7', 'name' => 'B'],
            ['class' => 'Class 8', 'name' => 'A'],
            ['class' => 'Class 8', 'name' => 'B'],
            ['class' => 'Class 8', 'name' => 'C'],
            ['class' => 'Class 9', 'name' => 'A'],
            ['class' => 'Class 9', 'name' => 'B'],
            ['class' => 'Class 10', 'name' => 'A'],
            ['class' => 'Class 10', 'name' => 'B'],
        ])->map(function (array $row) use ($classes, $islamabad) {
            return Section::create([
                'campus_id' => $islamabad->id,
                'school_class_id' => $classes[$row['class']]->id,
                'name' => $row['name'],
                'capacity' => 40,
            ]);
        })->keyBy(fn (Section $section) => $section->schoolClass->name . '-' . $section->name);

        $subjects = collect([
            ['name' => 'Mathematics', 'code' => 'MTH'],
            ['name' => 'English', 'code' => 'ENG'],
            ['name' => 'Urdu', 'code' => 'URD'],
            ['name' => 'Physics', 'code' => 'PHY'],
            ['name' => 'Chemistry', 'code' => 'CHE'],
            ['name' => 'Biology', 'code' => 'BIO'],
            ['name' => 'Computer Science', 'code' => 'CSC'],
        ])->map(fn (array $data) => Subject::create(['campus_id' => $islamabad->id] + $data))->keyBy('name');

        $monthlyFee = FeeType::create([
            'campus_id' => $islamabad->id,
            'name' => 'Monthly Fee',
            'is_recurring' => true,
            'frequency' => 'monthly',
        ]);

        $examFee = FeeType::create([
            'campus_id' => $islamabad->id,
            'name' => 'Exam Fee',
            'is_recurring' => false,
            'frequency' => 'term',
        ]);

        $students = collect([
            ['Ahmed Bilal Khan', 'Class 9', 'A', 'Male', 'Bilal Ahmed Khan', '0312-3456789', 'Software Engineer', 'Ayesha Bilal', '0345-9876543', StudentStatus::ACTIVE],
            ['Sara Noor Fatima', 'Class 7', 'B', 'Female', 'Noor Muhammad', '0333-8765432', 'Businessman', 'Sadia Noor', '0340-8765432', StudentStatus::ACTIVE],
            ['Zaid Abbas Mirza', 'Class 10', 'A', 'Male', 'Abbas Mirza', '0321-5544332', 'Banker', 'Hina Abbas', '0321-5544333', StudentStatus::ACTIVE],
            ['Hina Arshad Malik', 'Class 8', 'C', 'Female', 'Arshad Malik', '0345-1122334', 'Teacher', 'Sana Malik', '0345-1122335', StudentStatus::ACTIVE],
            ['Omar Usman Sheikh', 'Class 6', 'A', 'Male', 'Usman Sheikh', '0300-9988776', 'Trader', 'Amina Sheikh', '0300-9988777', StudentStatus::ACTIVE],
            ['Amna Tariq Butt', 'Class 7', 'A', 'Female', 'Tariq Butt', '0311-2233445', 'Engineer', 'Fiza Tariq', '0311-2233446', StudentStatus::ACTIVE],
            ['Hamza Raza Khan', 'Class 8', 'A', 'Male', 'Raza Khan', '0312-9988001', 'Contractor', 'Rabia Raza', '0312-9988002', StudentStatus::ENROLLED],
            ['Khadija Imran Ali', 'Class 9', 'B', 'Female', 'Imran Ali', '0321-3344556', 'Doctor', 'Farah Imran', '0321-3344557', StudentStatus::ACTIVE],
            ['Faisal Akhtar Qazi', 'Class 10', 'B', 'Male', 'Akhtar Qazi', '0300-7766554', 'Advocate', 'Zehra Akhtar', '0300-7766555', StudentStatus::ACTIVE],
            ['Rabia Shahid Awan', 'Class 6', 'B', 'Female', 'Shahid Awan', '0333-2211009', 'Accountant', 'Lubna Shahid', '0333-2211010', StudentStatus::ACTIVE],
            ['Ali Hassan Siddiqui', 'Class 8', 'B', 'Male', 'Hassan Siddiqui', '0312-4455667', 'Architect', 'Maha Hassan', '0312-4455668', StudentStatus::ACTIVE],
            ['Maryam Zahid Baig', 'Class 7', 'B', 'Female', 'Zahid Baig', '0345-8877665', 'Lecturer', 'Nida Zahid', '0345-8877666', StudentStatus::ACTIVE],
        ])->values()->map(function (array $data, int $index) use ($islamabad, $classes, $sections, $year) {
            [$name, $className, $sectionName, $gender, $father, $fatherPhone, $occupation, $mother, $motherPhone, $status] = $data;

            $user = User::create([
                'campus_id' => $islamabad->id,
                'name' => $name,
                'email' => 'student' . ($index + 1) . '@alfalah.edu.pk',
                'phone' => $fatherPhone,
                'role' => UserRole::STUDENT,
                'password' => Hash::make('password'),
            ]);

            $student = Student::create([
                'campus_id' => $islamabad->id,
                'user_id' => $user->id,
                'registration_no' => 'REG-' . (2018 + ($index % 5)) . '-' . str_pad((string) (188 + $index), 5, '0', STR_PAD_LEFT),
                'b_form_no' => '61101-' . str_pad((string) (1234567 + $index), 7, '0', STR_PAD_LEFT) . '-' . (($index % 9) + 1),
                'date_of_birth' => Carbon::create(2010 + ($index % 4), ($index % 10) + 1, ($index % 24) + 1),
                'gender' => $gender,
                'blood_group' => ['O+', 'A+', 'B+', 'AB+'][$index % 4],
                'religion' => 'Islam',
                'enrollment_date' => Carbon::create(2019 + ($index % 4), 4, 1),
                'status' => $status,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@gmail.com',
                'address' => 'House ' . ($index + 10) . ', Street ' . (($index % 8) + 1) . ', G-11/2, Islamabad',
            ]);

            StudentParent::create([
                'campus_id' => $islamabad->id,
                'student_id' => $student->id,
                'father_name' => $father,
                'father_cnic' => '61101-' . str_pad((string) (9876543 + $index), 7, '0', STR_PAD_LEFT) . '-' . (($index % 9) + 1),
                'father_phone' => $fatherPhone,
                'father_occupation' => $occupation,
                'mother_name' => $mother,
                'mother_phone' => $motherPhone,
                'guardian_name' => $father,
                'guardian_phone' => $fatherPhone,
                'emergency_contact' => $fatherPhone,
            ]);

            StudentAcademicRecord::create([
                'campus_id' => $islamabad->id,
                'student_id' => $student->id,
                'academic_year_id' => $year->id,
                'school_class_id' => $classes[$className]->id,
                'section_id' => $sections[$className . '-' . $sectionName]->id,
                'roll_no' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
                'is_current' => true,
                'assigned_at' => Carbon::create(2025, 4, 1),
            ]);

            return $student;
        });

        $otherCampusUser = User::create([
            'campus_id' => $lahore->id,
            'name' => 'Lahore Admin',
            'email' => 'admin.lahore@alfalah.edu.pk',
            'phone' => '0301-0000000',
            'role' => UserRole::CAMPUS_ADMIN,
            'password' => Hash::make('password'),
        ]);

        $otherCampusStudentUser = User::create([
            'campus_id' => $lahore->id,
            'name' => 'Other Campus Student',
            'email' => 'lahore.student@alfalah.edu.pk',
            'phone' => '0302-0000000',
            'role' => UserRole::STUDENT,
            'password' => Hash::make('password'),
        ]);

        Student::create([
            'campus_id' => $lahore->id,
            'user_id' => $otherCampusStudentUser->id,
            'registration_no' => 'REG-2025-99999',
            'b_form_no' => '35202-7654321-1',
            'date_of_birth' => '2012-01-10',
            'gender' => 'Male',
            'blood_group' => 'A+',
            'religion' => 'Islam',
            'enrollment_date' => '2025-04-01',
            'status' => StudentStatus::ACTIVE,
            'email' => 'lahore.student@gmail.com',
            'address' => 'Johar Town, Lahore',
        ]);

        $today = Carbon::today();
        foreach ($students as $index => $student) {
            for ($offset = 0; $offset < 14; $offset++) {
                $status = match (true) {
                    $offset === 2 && $index % 4 === 0 => AttendanceStatus::ABSENT,
                    $offset === 5 && $index % 3 === 0 => AttendanceStatus::LEAVE,
                    $offset === 0 && $index % 5 === 0 => AttendanceStatus::LATE,
                    default => AttendanceStatus::PRESENT,
                };

                StudentAttendance::create([
                    'campus_id' => $islamabad->id,
                    'student_id' => $student->id,
                    'section_id' => $student->currentAcademicRecord->section_id,
                    'attendance_date' => $today->copy()->subDays($offset),
                    'status' => $status,
                    'method' => 'manual',
                    'marked_by' => $campusAdmin->id,
                ]);
            }
        }

        foreach ($students as $index => $student) {
            $months = collect([0, 1, 2, 3, 4, 5]);

            $months->each(function (int $monthOffset) use ($student, $year, $monthlyFee, $examFee, $campusAdmin, $index) {
                $billingMonth = Carbon::now()->startOfMonth()->subMonths($monthOffset);
                $amount = 4200;
                $discount = $index === 0 ? 420 : 0;
                $fine = $monthOffset === 3 ? 200 : 0;
                $net = $amount - $discount + $fine;
                $status = match (true) {
                    $monthOffset === 0 && in_array($index, [3, 11], true) => InvoiceStatus::UNPAID,
                    $monthOffset === 0 && in_array($index, [1, 8], true) => InvoiceStatus::PARTIAL,
                    default => InvoiceStatus::PAID,
                };

                $paid = match ($status) {
                    InvoiceStatus::UNPAID => 0,
                    InvoiceStatus::PARTIAL => $net - 700,
                    default => $net,
                };

                $invoice = FeeInvoice::create([
                    'campus_id' => $student->campus_id,
                    'student_id' => $student->id,
                    'academic_year_id' => $year->id,
                    'fee_type_id' => $monthOffset === 0 ? $examFee->id : $monthlyFee->id,
                    'billing_month' => $billingMonth,
                    'amount' => $amount,
                    'discount_amount' => $discount,
                    'fine_amount' => $fine,
                    'net_amount' => $net,
                    'paid_amount' => $paid,
                    'balance_amount' => $net - $paid,
                    'due_date' => $billingMonth->copy()->day(5),
                    'status' => $status,
                    'challan_no' => 'CH-' . $student->id . '-' . $billingMonth->format('Ym'),
                ]);

                if ($paid > 0) {
                    FeePayment::create([
                        'campus_id' => $student->campus_id,
                        'fee_invoice_id' => $invoice->id,
                        'student_id' => $student->id,
                        'amount_paid' => $paid,
                        'payment_date' => $billingMonth->copy()->day(min(8 + $index, 25)),
                        'method' => $index % 2 === 0 ? 'cash' : 'bank',
                        'received_by' => $campusAdmin->id,
                        'receipt_no' => 'RCPT-' . $student->id . '-' . $billingMonth->format('Ym'),
                    ]);
                }
            });
        }

        $examType = ExamType::create([
            'campus_id' => $islamabad->id,
            'name' => 'Mid Term',
            'weightage_percent' => 100,
        ]);

        $exam = Exam::create([
            'campus_id' => $islamabad->id,
            'academic_year_id' => $year->id,
            'term_id' => 1,
            'exam_type_id' => $examType->id,
            'school_class_id' => $classes['Class 9']->id,
            'name' => 'Mid Term 2025-26',
            'start_date' => '2025-10-10',
            'end_date' => '2025-10-20',
            'status' => ExamStatus::PUBLISHED,
        ]);

        $primaryStudent = $students->first();
        foreach ([
            ['Mathematics', 88],
            ['English', 74],
            ['Urdu', 82],
            ['Physics', 71],
            ['Chemistry', 65],
            ['Biology', 79],
            ['Computer Science', 91],
        ] as [$subjectName, $marks]) {
            Mark::create([
                'campus_id' => $islamabad->id,
                'exam_id' => $exam->id,
                'student_id' => $primaryStudent->id,
                'subject_id' => $subjects[$subjectName]->id,
                'obtained_marks' => $marks,
                'total_marks' => 100,
                'entered_by' => $teacherUser->id,
            ]);
        }

        collect([
            ['Class 9-A attendance marked', 'Attendance submitted by Bilal Ahmed for Class 9-A.', 'bi-check2-circle', 'success', now()->subMinutes(8)],
            ['Fee payment received', 'Payment received from Zaid Abbas Mirza for PKR 4,200.', 'bi-cash-coin', 'info', now()->subMinutes(22)],
            ['New admission enrolled', 'Hamza Raza Khan enrolled in Class 8-A.', 'bi-person-plus', 'warning', now()->subHour()],
            ['Fee defaulter alert', '14 students are overdue by more than 15 days.', 'bi-exclamation-triangle', 'danger', now()->subHours(2)],
            ['Bulk SMS sent', 'Exam schedule reminder sent to 218 parents.', 'bi-chat-dots', 'success', now()->subHours(3)],
        ])->each(function (array $row) use ($islamabad, $campusAdmin) {
            ActivityLog::create([
                'campus_id' => $islamabad->id,
                'user_id' => $campusAdmin->id,
                'title' => $row[0],
                'description' => $row[1],
                'icon' => $row[2],
                'tone' => $row[3],
                'logged_at' => $row[4],
            ]);
        });
    }
}
