# EDUS vs SmartSchool: Feature/Module Gap Analysis

Purpose: identify what EDUS (`sms-app`) is missing or shallow compared to `SmartSchool'system`, so EDUS can be upgraded with clear priorities.

## 1) Baseline Size Comparison

| Area | SmartSchool | EDUS (sms-app) | Gap Signal |
|---|---:|---:|---|
| Controllers | 233 | 25 | EDUS has a much smaller functional surface |
| Models | 154 | 27 | Fewer domain entities and business rules in EDUS |
| Views | 848 | 60 Blade views | EDUS has far less UI/report/print coverage |

## 2) Modules/Features Missing in EDUS (Present in SmartSchool)

These are largely absent as first-class modules in EDUS routes/controllers/models.

| Missing Module | SmartSchool Coverage | EDUS Status |
|---|---|---|
| Front Office CRM | Visitor purpose, enquiry, complaints, general calls, reference/source, dispatch/receive | Not implemented as dedicated module |
| Library Management | Books, issues/returns, members, due reports | Missing |
| Inventory & Store | Items, stock, suppliers, stores, issue/receive | Missing (only fixed assets module exists) |
| Transport | Routes, vehicles, pickup points, transport fee mapping | Missing |
| Rich Fee Ecosystem | Fee groups/masters/session groups, discounts/reminders, fees forward, balance-specific module | Partially missing; EDUS has core fee type/structure/invoice/payment only |
| Online Admission | Public online admission, applicant processing, post-admission flow | Missing |
| Payment Gateway Integrations | Many online gateways and callback controllers | Missing (no comparable gateway module) |
| ID Card & Certificate Suite | Student/staff IDs, transfer certificate, admit card, certificate generation templates | Missing |
| Parent/Student Portal Breadth | Dedicated user-side modules (exam, fees, timetable, homework, hostel, route, etc.) | Missing as separate portal areas |
| Homework Module | Assignment creation/distribution/submission tracking | Missing |
| Video Tutorial / Learning Media | Tutorial/content media module | Missing |
| Lesson Plan & Syllabus Tracking | Syllabus progress + lesson plan workflows | Missing |
| Calendar/Event Module | Calendar management and academic events | Missing |
| Chat / Messaging Workspace | Internal chat + message threading | Missing |
| Email/SMS Config Center | Dedicated gateway/config modules for communication | Missing as admin modules (only SmsService contract exists) |
| Alumni Management | Alumni records/reports | Missing |
| Audit & Addons Module | Dedicated audit logs module and add-on manager | Missing as explicit module |
| Biometric Integration | Biometric attendance integration | Missing |
| Print/PDF Framework Breadth | Extensive print templates and PDF report outputs | Limited in EDUS |
| CMS / Front Website Builder | Pages, menus, media blocks, themes/front CMS | Missing |
| Multi-Role Operational Panels | Richly separated panels (admin, student, parent, teacher, accountant, librarian) | Single admin route group with role gate |

## 3) Modules Present in EDUS but Incomplete/Shallow vs SmartSchool

| Module | EDUS Current Depth | Missing/Weak vs SmartSchool |
|---|---|---|
| Authentication, Roles, Permissions | Role middleware on routes (`role:...`) | Lacks full role-permission matrix module, sidebar/menu permission management, granular RBAC UI |
| Reports | `reports/index`, `reports/attendance`, `reports/fees` | Very limited report catalog; SmartSchool has broad student/exam/finance/library/inventory/HR reports + many print variants |
| Student Management | Core student CRUD + parent + academic record | Missing advanced workflows: transfers, disable reasons, timeline richness, broader student lifecycle utilities |
| Attendance | Mark/index student attendance | Missing subject-wise attendance, staff attendance module depth, attendance settings, deeper analytics |
| Exams & Results | Exam type/exam + mark entry | Missing exam groups, detailed exam schedule variants, marks division/grade systems, marksheet generation depth, online exams |
| Fee Management | Fee type/structure/invoice/payment | Missing fee category/group/master layers, fee reminders, fee forwarding, advanced discounting rules, broader fee reports/receipts |
| Employee/HR | Employee + payroll CRUD | Missing departments/designations modules, leave requests/types/approval flow, HR report depth, role-specific HR operations |
| Hostel | Hostel/room/allocation | Missing room type/house systems and broader hostel reporting/control depth |
| Notifications/Communication | Notification CRUD + SMS service interface | Missing configured multi-channel communication center (email/SMS gateways, templates, campaign/send logs, chat) |
| Asset Management | Asset category + asset + assignment | Good base, but not equivalent to SmartSchool inventory/store operations (stock lifecycle, supplier/store/issue/receive flow) |
| Academic Setup | Academic years/classes/sections/subjects | Missing broader academic controls: subject groups, batch subjects, class teacher mappings, richer timetable integration |
| Campus Scope | Good multi-campus context via middleware/service | Strong point in EDUS; however SmartSchool has broader per-module operational coverage built on top of scope |

## 4) CRUD Depth Gaps (High-Level)

Compared to SmartSchool, EDUS frequently has only base CRUD where SmartSchool has full operational lifecycles:

- `Student`: EDUS CRUD vs SmartSchool CRUD + transfer + timeline + status controls + more report surfaces.
- `Fees`: EDUS invoices/payments vs SmartSchool fee architecture (category/type/group/master/session mapping + reminders + balances + receipts variety).
- `Exams`: EDUS exam + marks vs SmartSchool exam ecosystem (grouping, schedules, grade divisions, result and marksheet richness, online exams).
- `HR`: EDUS employee/payroll vs SmartSchool HR suite (leave workflow, department/designation, attendance depth).
- `Reporting`: EDUS 3 core screens vs SmartSchool's multi-domain report library and print outputs.

## 5) Recommended Upgrade Priority for EDUS

1. Expand core academic + exam + fee depth (highest operational value).
2. Add missing HR leave and attendance depth.
3. Build reporting/print subsystem (PDF/receipts/analytics).
4. Add transport + library + inventory/store modules.
5. Add front-office CRM, communication center, homework/syllabus.
6. Add online admission + payment integrations.
7. Add certificate/ID/admit-card generation and CMS/front website modules.

## 6) Practical Upgrade Target (Phase-1 MVP Parity)

For fastest business parity gains, phase-1 should include:
- Fee architecture expansion (`category/group/master/discount/reminder/balance`).
- Exam/result expansion (`schedule/grade division/marksheet/report`).
- Student lifecycle expansion (`transfer/timeline/status controls`).
- HR expansion (`department/designation/leave workflow/staff attendance`).
- Reporting pack (attendance, fees, exams, student, payroll) + printable outputs.


