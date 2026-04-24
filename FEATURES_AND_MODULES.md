# SmartSchool System: Complete Features and Modules

This document lists the project modules and feature coverage based on the current codebase structure in:
- `application/controllers`
- `application/models`
- `application/views`

## 1) Module-Wise Feature Coverage

| Module | What It Covers | Main Controllers | Main Models | Main Views |
|---|---|---|---|---|
| Authentication, Users, Roles, Permissions | Login/reset flows, user management, role/permission control, module/side menu permissions, activity logs | `Admin`, `Users`, `Roles`, `Module`, `Sidemenu`, `Userlog`, `Site`, `App` | `User_model`, `Role_model`, `Rolepermission_model`, `Module_model`, `Modulepermission_model`, `Userpermission_model`, `Userlog_model`, `Sidebarmenu_model` | `views/admin/*`, `views/user/*`, `views/layout/*` |
| School Setup & Session Settings | Global school settings, sessions, classes/sections, academic defaults | `School`, `Schsettings`, `Sessions`, `Classes`, `Sections`, `Common`, `Systemfield`, `Customfield` | `Setting_model`, `Session_model`, `Class_model`, `Section_model`, `Classsection_model`, `Customfield_model`, `Student_edit_field_model` | `views/setting/*`, `views/class/*`, `views/section/*`, `views/session/*` |
| Student Information System | Student admission/profile lifecycle, disable/reasons, student timeline, class/section mapping, transfers | `Student`, `Stdtransfer`, `Timeline`, `Disable_reason`, `Onlinestudent` | `Student_model`, `Studentsession_model`, `Disable_reason_model`, `Timeline_model`, `Onlinestudent_model` | `views/student/*`, `views/admin/student*`, `views/user/*` |
| Academic Curriculum | Subjects, subject groups, teacher-subject mapping, lesson planning and syllabus progress | `Subject`, `Subjectgroup`, `Batchsubject`, `Lessonplan`, `Syllabus`, `Teacher` | `Subject_model`, `Subjectgroup_model`, `Studentsubjectgroup_model`, `Teachersubject_model`, `Lessonplan_model`, `Syllabus_model`, `Batchsubject_model` | `views/admin/*subject*`, `views/user/subject/*`, `views/user/syllabus/*` |
| Timetable & Calendar | Class/subject schedules, timetable generation/display, calendar events | `Timetable`, `Calendar`, `Examschedule`, `Exam_schedule` | `Timetable_model`, `Subjecttimetable_model`, `Class_section_time_model`, `Calendar_model`, `Examschedule_model` | `views/admin/*timetable*`, `views/user/timetable/*`, `views/user/visitor/*` |
| Attendance Management | Student attendance, subject attendance, staff attendance, attendance settings/reports | `Stuattendence`, `Subjectattendence`, `Staffattendance`, `Attendencereports`, `Attendence` | `Stuattendence_model`, `Studentsubjectattendence_model`, `Staffattendancemodel`, `StaffAttendaceSetting_model`, `StudentAttendaceSetting_model`, `Attendencetype_model` | `views/attendencereports/*`, `views/user/attendence/*`, `views/admin/*attendance*` |
| Examination & Results | Exams, exam groups, schedules, marks entry, grade setup, marksheets, online exams and questions | `Exam`, `Examgroup`, `Examresult`, `Examschedule`, `Mark`, `Marksdivision`, `Marksheet`, `Onlineexam`, `Question` | `Exam_model`, `Examgroup_model`, `Examgroupstudent_model`, `Examstudent_model`, `Examsubject_model`, `Examresult_model`, `Mark_model`, `Marksdivision_model`, `Grade_model`, `Marksheet_model`, `Onlineexam_model`, `Onlineexamquestion_model`, `Onlineexamresult_model`, `Question_model` | `views/admin/*exam*`, `views/reports/*onlineexam*`, `views/user/onlineexam/*`, `views/user/mark/*` |
| Fees & Student Billing | Fee categories/types/groups/masters, fee collection, discounts/reminders, fee forward, due/balance reporting | `Feecategory`, `Feetype`, `Feegroup`, `Feemaster`, `Feediscount`, `Feereminder`, `Feesforward`, `Studentfee`, `Balancefees`, `Transaction`, `Offlinepayment` | `Feecategory_model`, `Feetype_model`, `Feegroup_model`, `Feegrouptype_model`, `Feemaster_model`, `Feesessiongroup_model`, `Studentfeemaster_model`, `Studentfee_model`, `StudentAppliedDiscount_model`, `Balancefees_model`, `Feereminder_model`, `OfflinePayment_model` | `views/feecategory/*`, `views/feetype/*`, `views/studentfee/*`, `views/balancefees/*`, `views/reports/*fees*`, `views/print/*fee*`, `views/user/student/*fees*` |
| Finance & Accounting | Income/expense heads, accounting entries, finance reports, accountant operations | `Income`, `Incomehead`, `Expense`, `Expensehead`, `Financereports`, `Transaction` | `Income_model`, `Incomehead_model`, `Expense_model`, `Expensehead_model`, `Accountant_model` | `views/financereports/*`, `views/reports/*income*`, `views/reports/*expense*` |
| Payroll & HR | Staff profiles, department/designation setup, payroll processing, leave workflows | `Staff`, `Department`, `Designation`, `Payroll`, `Leaverequest`, `Leavetypes`, `Approve_leave`, `Apply_leave` | `Staff_model`, `Staffroles_model`, `Department_model`, `Designation_model`, `Payroll_model`, `Leaverequest_model`, `Leavetypes_model`, `Apply_leave_model` | `views/admin/*staff*`, `views/reports/*human_resource*`, `views/user/teacher/*` |
| ID Cards, Certificates & Documents | Student/staff ID generation, certificates, transfer certificates, admit cards, print headers/footers | `Generateidcard`, `Generatestaffidcard`, `Studentidcard`, `Staffidcard`, `Generatecertificate`, `Certificate`, `Transfercertificate`, `Admitcard`, `Print_headerfooter` | `Generateidcard_model`, `Generatestaffidcard_model`, `Student_id_card_model`, `Staffidcard_model`, `Generatecertificate_model`, `Certificate_model`, `Transfercertificate_model`, `Admitcard_model` | `views/print/*`, `views/admin/*certificate*`, `views/reports/*admission*` |
| Library Management | Book catalog, issue/return, member management, inventory/issue reports | `Book`, `Member` | `Book_model`, `Bookissue_model`, `Librarymanagement_model`, `Librarymember_model`, `Librarian_model` | `views/reports/*library*`, `views/admin/*book*` |
| Inventory & Store | Items, stock management, item category/store/supplier, issue/receive workflows | `Item`, `Issueitem`, `Itemcategory`, `Itemstock`, `Itemstore`, `Itemsupplier`, `Receive`, `Dispatch` | `Item_model`, `Itemissue_model`, `Itemcategory_model`, `Itemstock_model`, `Itemstore_model`, `Itemsupplier_model`, `Dispatch_model` | `views/reports/*inventory*`, `views/admin/*item*` |
| Transport | Route/vehicle setup, route-vehicle mapping, pickup points, transport fee components | `Transport`, `Route`, `Vehroute`, `Vehicle`, `Pickuppoint` | `Route_model`, `Vehroute_model`, `Vehicle_model`, `Pickuppoint_model`, `Routepickuppoint_model`, `Transportfee_model`, `Studenttransportfee_model` | `views/user/route/*`, `views/reports/*transport*`, `views/admin/*transport*` |
| Hostel | Hostel setup, room types/rooms, student hostel allocation | `Hostel`, `Hostelroom`, `Roomtype`, `Schoolhouse` | `Hostel_model`, `Hostelroom_model`, `Roomtype_model`, `Schoolhouse_model`, `Houselist_model` | `views/user/hostelroom/*`, `views/admin/*hostel*` |
| Front Office & CRM | Visitor logging, enquiries, complaints, calls, references and source tracking | `Visitors`, `Visitorspurpose`, `Enquiry`, `Complaint`, `Complainttype`, `Generalcall`, `Reference`, `Source`, `Dispatch`, `Receive` | `Visitors_model`, `Visitors_purpose_model`, `Enquiry_model`, `Complaint_Model`, `ComplaintType_model`, `General_call_model`, `Reference_model`, `Source_model`, `Dispatch_model` | `views/admin/*front_office*`, `views/reports/*front_office*` |
| Communication | Email/SMS configuration, messaging/notifications, chat, announcements/content sharing | `Mailsms`, `Emailconfig`, `Smsconfig`, `Notification`, `Chat`, `Content` | `Emailconfig_model`, `Smsconfig_model`, `Notification_model`, `Notificationsetting_model`, `Chat_model`, `Chatuser_model`, `Messages_model`, `Content_model`, `Sharecontent_model` | `views/emailconfig/*`, `views/smsconfig/*`, `views/user/notification/*`, `views/user/chat/*` |
| Homework & Learning Content | Homework creation/distribution, student homework views, media/tutorial content | `Homework`, `Video_tutorial`, `Content` | `Homework_model`, `Video_tutorial_model`, `Uploadcontent_model`, `Filetype_model` | `views/homework/*`, `views/user/video_tutorial/*`, `views/front/*` |
| Online Admission & Payment | Public online admission flow, invoice/payment processing, callback handling with multiple gateways | `Onlineadmission` (admin), `application/controllers/onlineadmission/*`, `Webhooks`, `Offlinepayment`, `gateway_ins/*` | `Onlinestudent_model`, `Paymentsetting_model`, `Gateway_ins_model`, `OfflinePayment_model` | `views/onlineadmission/*`, `views/front/*`, `views/user/offlinepayment/*` |
| Website / CMS / Frontend Theme | Front pages, menus/pages/media blocks, themes, front CMS sections | `Welcome`, `Welcomes`, `Frontcms`, `Theme`, `FrontTheme`, `Category`, `Contenttype` | `Cms_menu_model`, `Cms_menuitems_model`, `Cms_page_model`, `Cms_page_content_model`, `Cms_media_model`, `Cms_program_model`, `Frontcms_setting_model`, `Category_model`, `Contenttype_model` | `views/front/*`, `views/themes/*`, `views/category/*`, `views/layout/*` |
| Utilities, Integrations & Platform Ops | Cron jobs, migrations/updater, biometric integration, addons, audit/logging, language/currency, captcha | `Cron`, `Migrate`, `Updater`, `Biometric`, `Addons`, `Audit`, `Language`, `Currency`, `Captcha`, `Api_test` | `Audit_model`, `Addons_model`, `Language_model`, `Langpharses_model`, `Currency_model`, `Captcha_model`, `Admin_model` | `views/admin/*`, `views/errors/*` |
| Reports & Printing | Operational and analytical reporting across students, fees, exams, library, inventory, HR; printable/PDF outputs | `Report`, `Attendencereports`, `Financereports`, `Balancefees`, `Transaction` | Multiple reporting models across fee/exam/student/library/inventory domains | `views/reports/*`, `views/print/*`, `views/attendencereports/*`, `views/financereports/*` |

## 2) User-Facing Panel Modules (`application/controllers/user`)

- `Apply_leave`: leave requests from user panel.
- `Attendence`: student/child attendance view.
- `Book`: library book interactions.
- `Calendar`: calendar/event views.
- `Chat`: messaging/chat in user panel.
- `Content`: user-facing content access.
- `Default`: landing/default panel routes.
- `Exam`: exam result/related user views.
- `Examschedule`: schedule view for users.
- `Homework`: homework list/details.
- `Hostel`, `Hostelroom`: hostel and room details.
- `Mark`: marks display.
- `Notification`: notifications list.
- `Offlinepayment`: upload/track offline payment proofs.
- `Onlineexam`: take/view online exams.
- `Route`: transport route details.
- `Studentfee`: student fee details and dues.
- `Subject`: subject lists/details.
- `Syllabus`: syllabus progress view.
- `Teacher`: teacher listing/details.
- `Timeline`: timeline/activity for student.
- `Timetable`: timetable display.
- `User`: profile/account operations.
- `Video_tutorial`: tutorial/media access.
- `Visitors`: visitor/front-office interaction views.

## 3) Online Admission Gateway Coverage (`application/controllers/onlineadmission`)

- `Billplz`
- `Cashfree`
- `Ccavenue`
- `Checkout`
- `Dpopay`
- `Flutterwave`
- `Instamojo`
- `Ipayafrica`
- `Jazzcash`
- `Kowri`
- `Midtrans`
- `Mollie`
- `Momopay`
- `Onepay`
- `Payfast`
- `Payhere`
- `Paypal`
- `Paystack`
- `Paytm`
- `Payu`
- `Pesapal`
- `Razorpay`
- `Skrill`
- `Sslcommerz`
- `Stripe`
- `Toyyibpay`
- `Twocheckout`
- `Walkingm`

Additional gateway callback controllers in `application/controllers/gateway_ins`:
- `Ihela`, `Payfast`, `Payhere`, `Skrill`, `Toyyibpay`, `Twocheckout`

## 4) Root-Level Platform Controllers (`application/controllers`)

- `App`
- `Attendencereports`
- `Balancefees`
- `Biometric`
- `Category`
- `Classes`
- `Common`
- `Cron`
- `Emailconfig`
- `Feecategory`
- `Feemaster`
- `Feetype`
- `Financereports`
- `FrontTheme`
- `Homework`
- `Migrate`
- `Report`
- `School`
- `Schsettings`
- `Sections`
- `Sessions`
- `Site`
- `Smsconfig`
- `Student`
- `Studentfee`
- `Theme`
- `Webhooks`
- `Welcome`
- `Welcomes`

## 5) Complete Admin Controller Inventory (`application/controllers/admin`)

- `Addons`
- `Admin`
- `Adminuser`
- `Admitcard`
- `Alumni`
- `Api_test`
- `Approve_leave`
- `Audit`
- `Batchsubject`
- `Book`
- `Calendar`
- `Captcha`
- `Certificate`
- `Chat`
- `Complaint`
- `Complainttype`
- `Content`
- `Contenttype`
- `Currency`
- `Customfield`
- `Department`
- `Designation`
- `Disable_reason`
- `Dispatch`
- `Enquiry`
- `Exam`
- `Exam_schedule`
- `Examgroup`
- `Examresult`
- `Examschedule`
- `Expense`
- `Expensehead`
- `Feediscount`
- `Feegroup`
- `Feemaster`
- `Feereminder`
- `Feesforward`
- `Feetype`
- `Frontcms`
- `Generalcall`
- `Generatecertificate`
- `Generateidcard`
- `Generatestaffidcard`
- `Grade`
- `Holiday`
- `Hostel`
- `Hostelroom`
- `Income`
- `Incomehead`
- `Issueitem`
- `Item`
- `Itemcategory`
- `Itemstock`
- `Itemstore`
- `Itemsupplier`
- `Language`
- `Leaverequest`
- `Leavetypes`
- `Lessonplan`
- `Mailsms`
- `Mark`
- `Marksdivision`
- `Marksheet`
- `Member`
- `Module`
- `Notification`
- `Offlinepayment`
- `Onlineadmission`
- `Onlineexam`
- `Onlinestudent`
- `Paymentsettings`
- `Payroll`
- `Pickuppoint`
- `Print_headerfooter`
- `Question`
- `Receive`
- `Reference`
- `Resume`
- `Roles`
- `Roomtype`
- `Route`
- `Schoolhouse`
- `Sidemenu`
- `Source`
- `Staff`
- `Staffattendance`
- `Staffidcard`
- `Stdtransfer`
- `Stuattendence`
- `Studentidcard`
- `Subject`
- `Subjectattendence`
- `Subjectgroup`
- `Syllabus`
- `Systemfield`
- `Teacher`
- `Timeline`
- `Timetable`
- `Transaction`
- `Transfercertificate`
- `Transport`
- `Updater`
- `Userlog`
- `Users`
- `Vehicle`
- `Vehroute`
- `Video_tutorial`
- `Visitors`
- `Visitorspurpose`

## 6) Complete Model Inventory (`application/models`)

- `Accountant_model`
- `Addons_model`
- `Admin_model`
- `Admitcard_model`
- `Alumni_model`
- `Apply_leave_model`
- `Attendencetype_model`
- `Audit_model`
- `Balancefees_model`
- `Batchsubject_model`
- `Book_model`
- `Bookissue_model`
- `Calendar_model`
- `Captcha_model`
- `Category_model`
- `Certificate_model`
- `Chat_model`
- `Chatuser_model`
- `Class_model`
- `Class_section_time_model`
- `Classsection_model`
- `Classteacher_model`
- `Cms_media_model`
- `Cms_menu_model`
- `Cms_menuitems_model`
- `Cms_page_content_model`
- `Cms_page_model`
- `Cms_program_model`
- `Complaint_Model`
- `ComplaintType_model`
- `Content_model`
- `Contenttype_model`
- `Currency_model`
- `Customfield_model`
- `Department_model`
- `Designation_model`
- `Disable_reason_model`
- `Dispatch_model`
- `Emailconfig_model`
- `Enquiry_model`
- `Exam_model`
- `Examgroup_model`
- `Examgroupstudent_model`
- `Examresult_model`
- `Examschedule_model`
- `Examstudent_model`
- `Examsubject_model`
- `Expense_model`
- `Expensehead_model`
- `Feecategory_model`
- `Feediscount_model`
- `Feegroup_model`
- `Feegrouptype_model`
- `Feemaster_model`
- `Feereminder_model`
- `Feesessiongroup_model`
- `Feetype_model`
- `Filetype_model`
- `Frontcms_setting_model`
- `Gateway_ins_model`
- `General_call_model`
- `Generatecertificate_model`
- `Generateidcard_model`
- `Generatestaffidcard_model`
- `Grade_model`
- `Holiday_model`
- `Homework_model`
- `Hostel_model`
- `Hostelroom_model`
- `Houselist_model`
- `Income_model`
- `Incomehead_model`
- `Item_model`
- `Itemcategory_model`
- `Itemissue_model`
- `Itemstock_model`
- `Itemstore_model`
- `Itemsupplier_model`
- `Langpharses_model`
- `Language_model`
- `Leaverequest_model`
- `Leavetypes_model`
- `Lessonplan_model`
- `Librarian_model`
- `Librarymanagement_model`
- `Librarymember_model`
- `Mark_model`
- `Marksdivision_model`
- `Marksheet_model`
- `Messages_model`
- `Module_model`
- `Modulepermission_model`
- `Notification_model`
- `Notificationsetting_model`
- `OfflinePayment_model`
- `Onlineexam_model`
- `Onlineexamquestion_model`
- `Onlineexamresult_model`
- `Onlinestudent_model`
- `Paymentsetting_model`
- `Payroll_model`
- `Pickuppoint_model`
- `Question_model`
- `Reference_model`
- `Resume_model`
- `Role_model`
- `Rolepermission_model`
- `Roomtype_model`
- `Route_model`
- `Routepickuppoint_model`
- `Schoolhouse_model`
- `Section_model`
- `Session_model`
- `Setting_model`
- `Sharecontent_model`
- `Sidebarmenu_model`
- `Smsconfig_model`
- `Source_model`
- `Staff_model`
- `StaffAttendaceSetting_model`
- `Staffattendancemodel`
- `Staffidcard_model`
- `Staffroles_model`
- `Stuattendence_model`
- `Student_edit_field_model`
- `Student_id_card_model`
- `Student_model`
- `StudentAppliedDiscount_model`
- `StudentAttendaceSetting_model`
- `Studentfee_model`
- `Studentfeemaster_model`
- `Studentsession_model`
- `Studentsubjectattendence_model`
- `Studentsubjectgroup_model`
- `Studenttransportfee_model`
- `Subject_model`
- `Subjectgroup_model`
- `Subjecttimetable_model`
- `Syllabus_model`
- `Teacher_model`
- `Teachersubject_model`
- `Timeline_model`
- `Timetable_model`
- `Transfercertificate_model`
- `Transportfee_model`
- `Uploadcontent_model`
- `User_model`
- `Userlog_model`
- `Userpermission_model`
- `Vehicle_model`
- `Vehroute_model`
- `Video_tutorial_model`
- `Visitors_model`
- `Visitors_purpose_model`

## 7) End-to-End Workflows (How Modules Work)

| Module | Typical Workflow |
|---|---|
| Authentication & Authorization | `Admin/Site` login -> credentials validated (`User_model`) -> role/permission loaded (`Role_model`, `Rolepermission_model`, `Userpermission_model`) -> menu rendered (`Sidebarmenu_model`) -> actions logged (`Userlog_model`). |
| Session & Academic Setup | Create session (`Session_model`) -> define classes/sections (`Class_model`, `Section_model`, `Classsection_model`) -> configure school defaults (`Setting_model`) -> assign active session for operations. |
| Student Lifecycle | Add student profile (`Student_model`) -> assign session/class/section (`Studentsession_model`) -> update custom fields (`Student_edit_field_model`) -> track timeline (`Timeline_model`) -> transfer/disable when needed (`Stdtransfer`, `Disable_reason_model`). |
| Staff Lifecycle | Create staff record (`Staff_model`) -> map department/designation (`Department_model`, `Designation_model`) -> assign role (`Staffroles_model`) -> manage attendance (`Staffattendancemodel`) -> process payroll (`Payroll_model`). |
| Attendance (Student/Staff) | Configure attendance settings -> mark attendance (daily/subject/staff) -> save in `Stuattendence_model`/`Studentsubjectattendence_model`/`Staffattendancemodel` -> generate attendance reports (`Attendencereports`). |
| Subject & Curriculum | Create subjects (`Subject_model`) -> create subject groups (`Subjectgroup_model`) -> assign teacher-subject (`Teachersubject_model`) -> plan lesson/syllabus (`Lessonplan_model`, `Syllabus_model`) -> track completion status in reports/views. |
| Timetable Management | Define class-section time slots (`Class_section_time_model`) -> map subjects/teachers (`Subjecttimetable_model`) -> publish timetable (`Timetable_model`) -> display in admin and user panel. |
| Exams & Results | Create exam/exam group (`Exam_model`, `Examgroup_model`) -> assign students/subjects (`Examstudent_model`, `Examsubject_model`) -> schedule exams (`Examschedule_model`) -> enter marks (`Mark_model`) -> compute result/grade (`Examresult_model`, `Grade_model`) -> publish marksheet (`Marksheet_model`). |
| Online Exams | Create online exam (`Onlineexam_model`) -> build question bank (`Question_model`, `Onlineexamquestion_model`) -> student attempts via user panel -> answers evaluated -> results stored (`Onlineexamresult_model`) -> shown in report/user views. |
| Fee Structure Setup | Create fee category/type/group (`Feecategory_model`, `Feetype_model`, `Feegroup_model`) -> create fee master (`Feemaster_model`) -> map session/group (`Feesessiongroup_model`) -> assign to student (`Studentfeemaster_model`). |
| Fee Collection | Open student fee page (`Studentfee`) -> load dues (`Studentfee_model`) -> apply discounts/fines (`StudentAppliedDiscount_model`) -> collect payment (online/offline) -> record transactions -> produce receipt/print views. |
| Financial Accounting | Configure income/expense heads (`Incomehead_model`, `Expensehead_model`) -> create entries (`Income_model`, `Expense_model`) -> aggregate by date/category -> render finance reports (`Financereports`, report views). |
| Transport | Create routes and pickup points (`Route_model`, `Pickuppoint_model`) -> map vehicles/routes (`Vehroute_model`, `Routepickuppoint_model`) -> assign student transport fee (`Studenttransportfee_model`) -> track/report transport fee collection. |
| Hostel | Create hostel and room types (`Hostel_model`, `Roomtype_model`) -> create rooms (`Hostelroom_model`) -> assign students to rooms -> view allocations in admin/user hostel screens. |
| Library | Create books (`Book_model`) -> register members (`Librarymember_model`) -> issue/return books (`Bookissue_model`) -> compute due/availability -> generate library reports. |
| Inventory/Store | Create items/categories/stores/suppliers (`Item_model`, `Itemcategory_model`, `Itemstore_model`, `Itemsupplier_model`) -> stock in/out (`Itemstock_model`) -> issue items (`Itemissue_model`) -> produce stock/issue reports. |
| Front Office | Register visitor/enquiry/complaint/call (`Visitors_model`, `Enquiry_model`, `Complaint_Model`, `General_call_model`) -> track source/reference (`Source_model`, `Reference_model`) -> handle dispatch/receive logs (`Dispatch_model`) -> report follow-up status. |
| Communication | Configure email/SMS gateway (`Emailconfig_model`, `Smsconfig_model`) -> compose/send notifications (`Notification_model`, `Messages_model`) -> optional chat (`Chat_model`, `Chatuser_model`) -> user receives updates in panel. |
| Homework & Content | Teacher/admin creates homework (`Homework_model`) -> assign to class/section -> students view/submit in user panel -> track status -> publish tutorial/media content (`Video_tutorial_model`, `Uploadcontent_model`). |
| Certificates & IDs | Configure template/settings -> generate student/staff IDs (`Generateidcard_model`, `Generatestaffidcard_model`) -> generate certificates/TC/admit cards (`Generatecertificate_model`, `Transfercertificate_model`, `Admitcard_model`) -> print/export through print views. |
| Online Admission & Payment | Public form opened (`Welcome`/front views) -> applicant submits data (`Onlinestudent_model`) -> invoice/payment initialized (`Paymentsetting_model`) -> gateway controller processes payment (`onlineadmission/*`) -> callback confirms (`gateway_ins/*`/`Webhooks`) -> admission/payment status updated. |
| CMS/Website | Admin manages pages/menus/media (`Cms_page_model`, `Cms_menu_model`, `Cms_media_model`) -> theme/front settings applied (`Frontcms_setting_model`) -> content rendered on public website (`Welcome`, `FrontTheme`, `Theme`). |
| Reporting & Printing | Filter criteria submitted in report controller (`Report`, `Attendencereports`, `Financereports`) -> data fetched from domain models -> render tabular report views -> optional PDF/print templates in `views/print/*`. |
| Scheduled/Platform Ops | Cron endpoint triggered (`Cron`) -> periodic tasks run (reminders, status jobs, etc.) -> migration/update via `Migrate`/`Updater` when required -> maintenance/audit controls available (`Audit`, hook/config support). |
