<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniEventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CertificateTemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeInvoiceController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\FrontOfficeComplaintController;
use App\Http\Controllers\FrontOfficeEnquiryController;
use App\Http\Controllers\FrontOfficeVisitorController;
use App\Http\Controllers\GradeScaleController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\HostelAllocationController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoryItemIssueController;
use App\Http\Controllers\InventorySupplierController;
use App\Http\Controllers\IdCardTemplateController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\LibraryBookController;
use App\Http\Controllers\LibraryIssueController;
use App\Http\Controllers\LibraryMemberController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnlineExamController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffLeaveController;
use App\Http\Controllers\StaffRatingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SyllabusProgressController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TransportAssignmentController;
use App\Http\Controllers\TransportRouteController;
use App\Http\Controllers\TransportVehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');

    // Online Admission Form (for parents/students)
    Route::get('/admission', [\App\Http\Controllers\AdmissionController::class, 'create'])->name('admission.create');
    Route::post('/admission', [\App\Http\Controllers\AdmissionController::class, 'store'])->name('admission.store');

    // SaaS Registration (for new schools)
    Route::get('/register', [\App\Http\Controllers\RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\RegistrationController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::post('/campus/switch', [CampusController::class, 'update'])->name('campus.switch');

    // Portal Redirect
    Route::get('/dashboard', function() {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }
        return match($user->role->value) {
            'campus_admin', 'principal', 'accountant' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'parent' => redirect()->route('parent.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    // Super Admin Portal
    Route::prefix('super-admin')->name('super-admin.')->middleware('role:super_admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [\App\Http\Controllers\SuperAdmin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\SuperAdmin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [\App\Http\Controllers\SuperAdmin\ProfileController::class, 'password'])->name('profile.password');
        Route::get('/schools/{school}/impersonate', [\App\Http\Controllers\SuperAdmin\SchoolController::class, 'impersonate'])->name('schools.impersonate');
        Route::post('/leave-impersonation', [\App\Http\Controllers\SuperAdmin\SchoolController::class, 'leaveImpersonation'])->name('leave-impersonation')->withoutMiddleware('role:super_admin');
        Route::resource('schools', \App\Http\Controllers\SuperAdmin\SchoolController::class);
        Route::resource('users', \App\Http\Controllers\SuperAdmin\UserController::class);
        Route::get('/users/{user}/permissions', [\App\Http\Controllers\SuperAdmin\UserController::class, 'permissions'])->name('users.permissions');
        Route::post('/users/{user}/permissions', [\App\Http\Controllers\SuperAdmin\UserController::class, 'updatePermissions'])->name('users.permissions.update');
        Route::resource('permissions', \App\Http\Controllers\SuperAdmin\PermissionController::class);
        Route::resource('roles', \App\Http\Controllers\SuperAdmin\RoleController::class);
        Route::resource('plans', \App\Http\Controllers\SuperAdmin\PlanController::class);
        Route::get('/subscriptions', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::get('/subscriptions/{school}/edit', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'edit'])->name('subscriptions.edit');
        Route::put('/subscriptions/{school}', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'update'])->name('subscriptions.update');
        Route::get('/domains', [\App\Http\Controllers\SuperAdmin\DomainController::class, 'index'])->name('domains.index');
        Route::get('/settings', [\App\Http\Controllers\SuperAdmin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\SuperAdmin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('/audit-logs', [\App\Http\Controllers\SuperAdmin\AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    // Admin Portal
    Route::prefix('admin')->name('admin.')->middleware('role:campus_admin,principal,teacher,accountant')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('notifications', NotificationController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/fees', [ReportController::class, 'fees'])->name('reports.fees');
        Route::get('/reports/financials', [ReportController::class, 'financials'])->name('reports.financials');
        Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('/reports/transcripts', [ReportController::class, 'transcripts'])->name('reports.transcripts');
        Route::get('/reports/transcripts/{student}', [ReportController::class, 'showTranscript'])->name('reports.transcripts.show');

        // Hostel Management
        Route::resource('hostels', HostelController::class);
        Route::post('/hostels/{hostel}/rooms', [HostelController::class, 'addRoom'])->name('hostels.rooms.add');
        Route::resource('hostel-allocations', HostelAllocationController::class);

        // Assets Management
        Route::resource('assets', AssetController::class);
        Route::post('/assets/categories', [AssetController::class, 'storeCategory'])->name('assets.categories.store');
        Route::resource('asset-assignments', AssetAssignmentController::class);

        // Inventory Management (Consumables)
        Route::resource('inventory-items', InventoryItemController::class);
        Route::resource('inventory-suppliers', InventorySupplierController::class);
        Route::resource('inventory-item-issues', InventoryItemIssueController::class);

        // Transport Management
        Route::resource('transport-vehicles', TransportVehicleController::class);
        Route::resource('transport-routes', TransportRouteController::class);
        Route::post('/transport-routes/{transport_route}/pickup-points', [TransportRouteController::class, 'addPickupPoint'])->name('transport-routes.pickup-points.add');
        Route::resource('transport-assignments', TransportAssignmentController::class);

        // Library Management
        Route::resource('library-books', LibraryBookController::class);
        Route::resource('library-members', LibraryMemberController::class);
        Route::resource('library-issues', LibraryIssueController::class);

        // Front Office
        Route::resource('front-office-visitors', FrontOfficeVisitorController::class);
        Route::resource('front-office-enquiries', FrontOfficeEnquiryController::class);
        Route::resource('front-office-complaints', FrontOfficeComplaintController::class);

        // Academic Modules
        Route::resource('homework', HomeworkController::class);
        Route::resource('syllabus-progress', SyllabusProgressController::class);
        Route::resource('lesson-plans', LessonPlanController::class);
        Route::resource('online-exams', OnlineExamController::class);
        Route::post('/online-exams/{online_exam}/questions', [OnlineExamController::class, 'addQuestion'])->name('online-exams.questions.add');

        // Alumni Management
        Route::resource('alumni', AlumniController::class);
        Route::resource('alumni-events', AlumniEventController::class);

        // Certificates & ID Cards
        Route::resource('certificate-templates', CertificateTemplateController::class);
        Route::resource('id-card-templates', IdCardTemplateController::class);

        // Campuses
        Route::resource('campuses', CampusController::class);

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::get('users/{user}/permissions', [\App\Http\Controllers\Admin\UserPermissionController::class, 'index'])->name('users.permissions');
        Route::put('users/{user}/permissions', [\App\Http\Controllers\Admin\UserPermissionController::class, 'update'])->name('users.permissions.update');

        // Students
        Route::resource('students', StudentController::class);
        Route::resource('admission-inquiries', \App\Http\Controllers\Admin\AdmissionInquiryController::class);
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');

        // Staff
        Route::resource('employees', EmployeeController::class);
        Route::resource('payrolls', PayrollController::class);
        Route::resource('staff-attendance', StaffAttendanceController::class);
        Route::resource('staff-leaves', StaffLeaveController::class);
        Route::resource('staff-ratings', StaffRatingController::class);

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

        // Fee Management
        Route::resource('fee-types', FeeTypeController::class);
        Route::resource('fee-structures', FeeStructureController::class);
        Route::resource('fee-invoices', FeeInvoiceController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::get('/fee-invoices/{fee_invoice}/pay', [FeePaymentController::class, 'create'])->name('fee-payments.create');
        Route::post('/fee-invoices/{fee_invoice}/pay', [FeePaymentController::class, 'store'])->name('fee-payments.store');

        // Examinations
        Route::resource('exam-types', ExamTypeController::class);
        Route::resource('exams', ExamController::class);
        Route::resource('grade-scales', GradeScaleController::class);
        Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
        Route::get('/marks/entry', [MarkController::class, 'create'])->name('marks.create');
        Route::post('/marks', [MarkController::class, 'store'])->name('marks.store');

        // Academic Setup
        Route::resource('academic-years', AcademicYearController::class);
        Route::resource('classes', SchoolClassController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('subjects', SubjectController::class);
        Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
        Route::get('/timetable/slots', [TimetableController::class, 'slots'])->name('timetable.slots');
        Route::post('/timetable/slots', [TimetableController::class, 'storeSlot'])->name('timetable.slots.store');
        Route::delete('/timetable/slots/{timetable_slot}', [TimetableController::class, 'destroySlot'])->name('timetable.slots.destroy');
        Route::get('/timetable/create', [TimetableController::class, 'createEntry'])->name('timetable.create');
        Route::post('/timetable', [TimetableController::class, 'storeEntry'])->name('timetable.store');
        Route::delete('/timetable/{timetable_entry}', [TimetableController::class, 'destroyEntry'])->name('timetable.destroy');
    });

    // Teacher Portal
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    });

    // Student Portal
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    });

    // Parent Portal
    Route::prefix('parent')->name('parent.')->middleware('role:parent')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Parent\DashboardController::class, 'index'])->name('dashboard');
    });
});
