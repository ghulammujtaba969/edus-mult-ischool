# EDUS Multi iSchool (sms-app): Project Graph

## 1) Runtime Request Flow

```mermaid
flowchart LR
    U[Browser Client] --> P[public/index.php]
    P --> L[Laravel 10 Kernel]
    L --> MW[Web Middleware Stack]
    MW --> SCC[SetCampusContext]
    SCC --> CM[CampusManager]
    MW --> AUTH[auth + role middleware]
    AUTH --> RT[routes/web.php]
    RT --> CT[Controllers]
    CT --> SV[Services]
    CT --> MD[Eloquent Models]
    MD --> DB[(MySQL Database)]
    CT --> VW[Blade Views]
    VW --> U
```

## 2) Route & Access Graph

```mermaid
flowchart TB
    R[routes/web.php] --> G[guest]
    R --> A[auth]

    G --> LOGIN[AuthController: login/store]

    A --> SW[Campus switch]
    A --> ADM[admin prefix + role gate]

    ADM --> DASH[Dashboard]
    ADM --> STUD[Students]
    ADM --> EMP[Employees + Payroll]
    ADM --> ATT[Attendance]
    ADM --> FEE[Fee Types/Structures/Invoices/Payments]
    ADM --> EXM[Exam Types/Exams/Marks]
    ADM --> ACAD[Academic Years/Classes/Sections/Subjects]
    ADM --> HOS[Hostels + Allocations]
    ADM --> AST[Assets + Assignments]
    ADM --> REP[Reports]
    ADM --> NOTIF[Notifications]
    ADM --> CAMP[Campuses]
```

## 3) Application Module Graph

```mermaid
flowchart TB
    APP[app/] --> C[Http/Controllers]
    APP --> M[Models]
    APP --> S[Services]
    APP --> MW[Http/Middleware]
    APP --> E[Enums]

    C --> C25[25 controllers]
    M --> M27[27 models]
    S --> S7[7 services]
    MW --> MW11[11 middleware]

    C25 --> STUDC[StudentController]
    C25 --> FEEC[Fee* controllers]
    C25 --> EXAMC[Exam/Mark controllers]
    C25 --> EMPC[Employee/Payroll controllers]
    C25 --> HOSC[Hostel controllers]
    C25 --> ASTC[Asset controllers]
    C25 --> REPC[ReportController]
    C25 --> AUTHC[AuthController]

    S7 --> CAMPUSM[CampusManager]
    S7 --> FEESVC[FeeService]
    S7 --> ATSVC[AttendanceService]
    S7 --> REPSVC[ReportService]
    S7 --> RESSVC[ResultService]
    S7 --> SMSSVC[SmsService]
    S7 --> CHSVC[ChallanService]
```

## 4) Data Domain Graph (From Migrations/Models)

```mermaid
flowchart LR
    CAMP[Campus] --> AY[AcademicYear]
    AY --> TERM[Term]
    CAMP --> CLS[SchoolClass]
    CLS --> SEC[Section]
    CLS --> SUB[Subject]

    CAMP --> STU[Student]
    STU --> STAR[StudentAcademicRecord]
    STU --> SAT[StudentAttendance]

    CAMP --> EMP[Employee]
    CAMP --> PAY[Payroll]

    CAMP --> FT[FeeType]
    FT --> FS[FeeStructure]
    STU --> FI[FeeInvoice]
    FI --> FP[FeePayment]

    CAMP --> ET[ExamType]
    ET --> EX[Exam]
    EX --> MK[Mark]

    CAMP --> HOS[Hostel]
    HOS --> HR[HostelRoom]
    HR --> HA[HostelAllocation]

    CAMP --> AC[AssetCategory]
    AC --> AS[Asset]
    AS --> AA[AssetAssignment]
```

## 5) Filesystem Topology

```mermaid
flowchart TB
    ROOT[sms-app/] --> APPDIR[app/]
    ROOT --> CFG[config/]
    ROOT --> DB[database/]
    ROOT --> PUB[public/]
    ROOT --> RES[resources/]
    ROOT --> ROU[routes/]
    ROOT --> TST[tests/]
    ROOT --> VEN[vendor/]

    APPDIR --> CTR[Http/Controllers]
    APPDIR --> MOD[Models]
    APPDIR --> SRV[Services]
    APPDIR --> MID[Http/Middleware]
    RES --> BLD[views/*.blade.php]
    DB --> MIG[migrations]
```

## 6) Quick Notes

- Tech stack: `Laravel 10` + PHP `^8.1`.
- Multi-campus scoping is a core architectural concept via `SetCampusContext` + `CampusManager`.
- Most functional routes are under `admin` prefix with role-based access:
  - `campus_admin`, `principal`, `teacher`, `accountant`.
- Core product modules implemented: academics, students, staff/payroll, attendance, fees, exams/marks, hostel, assets, notifications, reports.
