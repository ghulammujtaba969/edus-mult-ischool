# EDUS Multi iSchool (sms-app): Features and Modules

This list is derived from `routes/web.php`, controllers, models, migrations, services, and feature tests.

## 1) Core Platform Modules

| Module | Features | Controllers | Key Models |
|---|---|---|---|
| Authentication & Access Control | Login/logout, guest/auth flows, role-based route protection (`campus_admin`, `principal`, `teacher`, `accountant`) | `AuthController` | `User` |
| Multi-Campus Context | Campus switching, session-based active campus, request-time campus scoping | `CampusController` | `Campus`, `AcademicYear`, `User` |
| Dashboard | KPI overview and landing after login | `DashboardController` | `Student`, `Employee`, `FeeInvoice`, `Exam` (aggregates) |
| Notifications | Create/list/manage internal notifications | `NotificationController` | `ActivityLog` / notifications table |
| Reports | General report screen, attendance report, fee report summaries | `ReportController` | `StudentAttendance`, `FeeInvoice`, `Student` |

## 2) Academic Management Modules

| Module | Features | Controllers | Key Models |
|---|---|---|---|
| Academic Setup | Manage academic years, classes, sections, subjects | `AcademicYearController`, `SchoolClassController`, `SectionController`, `SubjectController` | `AcademicYear`, `SchoolClass`, `Section`, `Subject`, `Term` |
| Student Management | Student enrollment, profile, parent info, current academic assignment, class/section roll mapping | `StudentController` | `Student`, `StudentParent`, `StudentAcademicRecord` |
| Attendance | Attendance index, mark attendance by section/date, attendance persistence | `AttendanceController` | `StudentAttendance`, `Student`, `Section` |
| Exam Setup | Exam types and exam schedule/configuration | `ExamTypeController`, `ExamController` | `ExamType`, `Exam`, `Term`, `SchoolClass` |
| Marks & Results | Marks entry/listing by exam/subject/student | `MarkController` | `Mark`, `Exam`, `Subject`, `Student` |

## 3) Finance & HR Modules

| Module | Features | Controllers | Key Models |
|---|---|---|---|
| Fee Management | Fee types, fee structures, invoice generation/listing, fee payment collection per invoice | `FeeTypeController`, `FeeStructureController`, `FeeInvoiceController`, `FeePaymentController` | `FeeType`, `FeeStructure`, `FeeInvoice`, `FeePayment` |
| Employee Management | Staff CRUD, role-linked user creation, employee details/status | `EmployeeController` | `Employee`, `User` |
| Payroll | Payroll generation and records | `PayrollController` | `Payroll`, `Employee` |

## 4) Infrastructure Modules

| Module | Features | Controllers | Key Models |
|---|---|---|---|
| Hostel Management | Hostel CRUD, room management, student allocations | `HostelController`, `HostelAllocationController` | `Hostel`, `HostelRoom`, `HostelAllocation` |
| Asset Management | Asset categories, assets, asset assignment tracking | `AssetController`, `AssetAssignmentController` | `AssetCategory`, `Asset`, `AssetAssignment` |

## 5) Service Layer Modules

Implemented service classes:
- `AttendanceService`
- `CampusManager`
- `ChallanService`
- `FeeService`
- `ReportService`
- `ResultService`
- `SmsService`

Contracts available in `app/Services/Contracts` for:
- Attendance
- Challan
- Fee
- Reporting
- Results
- SMS

## 6) Feature-Tested Functional Coverage

Feature tests confirm these working areas:
- `SmsMvpTest`: login/dashboard access, student profile access, campus-level data isolation.
- `StudentManagementTest`: student list, student enrollment, student update.
- `AcademicSetupTest`: view/create academic setup entities.
- `AttendanceManagementTest`: attendance index, mark attendance screen, save attendance.
- `FeeManagementTest`: fee type creation, fee structure setup.
- `ExamManagementTest`: exam type view, exam scheduling, marks entry screen.
- `EmployeeManagementTest`: employee list/create/update.

## 7) Complete Controller Inventory

- `AcademicYearController`
- `AssetAssignmentController`
- `AssetController`
- `AttendanceController`
- `AuthController`
- `CampusController`
- `DashboardController`
- `EmployeeController`
- `ExamController`
- `ExamTypeController`
- `FeeInvoiceController`
- `FeePaymentController`
- `FeeStructureController`
- `FeeTypeController`
- `HostelAllocationController`
- `HostelController`
- `MarkController`
- `NotificationController`
- `PayrollController`
- `ReportController`
- `SchoolClassController`
- `SectionController`
- `StudentController`
- `SubjectController`

## 8) Complete Model Inventory

- `AcademicYear`
- `ActivityLog`
- `Asset`
- `AssetAssignment`
- `AssetCategory`
- `Campus`
- `Employee`
- `Exam`
- `ExamType`
- `FeeInvoice`
- `FeePayment`
- `FeeStructure`
- `FeeType`
- `Hostel`
- `HostelAllocation`
- `HostelRoom`
- `Mark`
- `Payroll`
- `SchoolClass`
- `Section`
- `Student`
- `StudentAcademicRecord`
- `StudentAttendance`
- `StudentParent`
- `Subject`
- `Term`
- `User`
