<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\FeeInvoiceController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\HostelAllocationController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::post('/campus/switch', [CampusController::class, 'update'])->name('campus.switch');

    Route::prefix('admin')->name('admin.')->middleware('role:campus_admin,principal,teacher,accountant')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('notifications', NotificationController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/fees', [ReportController::class, 'fees'])->name('reports.fees');

        // Hostel Management
        Route::resource('hostels', HostelController::class);
        Route::post('/hostels/{hostel}/rooms', [HostelController::class, 'addRoom'])->name('hostels.rooms.add');
        Route::resource('hostel-allocations', HostelAllocationController::class);

        // Assets Management
        Route::resource('assets', AssetController::class);
        Route::post('/assets/categories', [AssetController::class, 'storeCategory'])->name('admin.assets.categories.store');
        Route::resource('asset-assignments', AssetAssignmentController::class);

        // Campuses
        Route::resource('campuses', CampusController::class);

        // Students
        Route::resource('students', StudentController::class);

        // Staff
        Route::resource('employees', EmployeeController::class);
        Route::resource('payrolls', PayrollController::class);

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

        // Fee Management
        Route::resource('fee-types', FeeTypeController::class);
        Route::resource('fee-structures', FeeStructureController::class);
        Route::resource('fee-invoices', FeeInvoiceController::class);
        Route::get('/fee-invoices/{fee_invoice}/pay', [FeePaymentController::class, 'create'])->name('fee-payments.create');
        Route::post('/fee-invoices/{fee_invoice}/pay', [FeePaymentController::class, 'store'])->name('fee-payments.store');

        // Examinations
        Route::resource('exam-types', ExamTypeController::class);
        Route::resource('exams', ExamController::class);
        Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
        Route::get('/marks/entry', [MarkController::class, 'create'])->name('marks.create');
        Route::post('/marks', [MarkController::class, 'store'])->name('marks.store');

        // Academic Setup
        Route::resource('academic-years', AcademicYearController::class);
        Route::resource('classes', SchoolClassController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('subjects', SubjectController::class);
    });
});
