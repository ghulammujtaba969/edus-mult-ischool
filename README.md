# EduCore SMS — School Management System

EduCore is a modern, multi-campus School Management System (SMS) built with Laravel. It handles everything from student enrollment and academic setup to complex financial billing and payroll.

## 🚀 Key Features

### 🏢 Multi-Campus Foundation
- **Multi-Tenancy**: Built-in campus isolation.
- **Global Scoping**: Campus admins only see their own data, while super admins can switch between all campuses.

### 🎓 Academic Management
- **Academic Setup**: Manage campuses, years, classes, sections, and subjects.
- **Student Enrollment**: Complete enrollment workflow with registration, guardian details, and class assignment.
- **Profiles**: Comprehensive views for student performance, attendance, and fee history.

### 💰 Finance & Fees
- **Fee Structures**: Configurable monthly or one-time fees per class.
- **Bulk Invoicing**: Generate hundreds of student invoices in seconds.
- **Payment Tracking**: Record partial or full payments with history.

### 📝 Examinations
- **Exam Scheduling**: Create and manage exam sessions for different classes.
- **Marks Entry**: Effortless marks recording for subjects across sections.

### 📅 Daily Operations
- **Attendance**: Daily student attendance marking.
- **Hostel**: Manage hostels, rooms, and student allocations.
- **Assets**: Track school inventory and assignments.
- **Notifications**: Internal announcement system for staff and parents.

### 👥 HR & Payroll
- **Staff Management**: Manage employee records and roles.
- **Payroll**: Automated monthly salary record generation and tracking.

### 📊 Reporting
- **Insights**: Basic reporting for fee collection, daily attendance, and hostel occupancy.

---

## 🛠️ Technical Stack
- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Blade, Alpine.js, Bootstrap 5
- **Database**: MySQL 8.0
- **Icons**: Bootstrap Icons

---

## ⚙️ Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd EduCore-SMS/sms-app
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configure Environment**:
   - Copy `.env.example` to `.env`
   - Set up your database credentials.

4. **Run Migrations & Seed**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Login**:
   - URL: `http://localhost/admin/dashboard`
   - User: `admin@alfalah.edu.pk`
   - Password: `password`

---

## 🧪 Testing
Run feature and unit tests with:
```bash
php artisan test
```

## 📜 License
Internal Project. All rights reserved.
