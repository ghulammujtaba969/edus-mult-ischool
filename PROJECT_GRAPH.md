# SmartSchool System: Project Graph

## 1) Runtime Flow

```mermaid
flowchart LR
    C[Client Browser / API Client] --> I[index.php]
    I --> CI[CodeIgniter Core in /system]
    CI --> H[pre_system hook: maintenance_hook::offline_check]
    H --> R[Router: application/config/routes.php]
    R --> CT[Controllers]
    CT --> LB[Autoloaded libs/helpers\nemail, session, form_validation,\nupload, pagination, Customlib\nurl, file, menu, security, cookie]
    CT --> MD[Models]
    MD --> DB[(MySQL / MariaDB)]
    DB --> MDB[(Optional multi-branch DB connections)]
    CT --> VW[Views]
    VW --> C
```

## 2) Application Domain Graph

```mermaid
flowchart TB
    APP[application/] --> CFG[config]
    APP --> CORE[core\n(MY_Controller, MY_Model)]
    APP --> HK[hooks]
    APP --> LIB[libraries\n(custom integrations)]
    APP --> CTR[controllers]
    APP --> MOD[models]
    APP --> VWS[views]
    APP --> TP[third_party]

    CTR --> ADM[admin/ controllers\n116]
    CTR --> USR[user/ controllers\n54]
    CTR --> OLA[onlineadmission/ controllers\n28]
    CTR --> GWI[gateway_ins/ controllers\n6]
    CTR --> ROOTC[(root controllers)\n29]

    MOD --> MODALL[154 model files]

    VWS --> VADM[admin views\n405]
    VWS --> VUSR[user views\n101]
    VWS --> VTH[themes views\n93]
    VWS --> VRPT[reports views\n56]
    VWS --> VOLA[onlineadmission views\n34]
    VWS --> VOTH[other view groups]

    TP --> OMP[omnipay]
    TP --> PHPM[PHPMailer]
    TP --> JWT[jwt]
    TP --> FBASE[firebase]
    TP --> PGW[payment SDKs\nbillplz, midtrans, pesapal]
```

## 3) Top-Level Filesystem Topology

```mermaid
flowchart TB
    ROOT[smartschool-system/] --> IDX[index.php]
    ROOT --> APPDIR[application/]
    ROOT --> SYSDIR[system/]
    ROOT --> BACKEND[backend/]
    ROOT --> UP[uploads/]
    ROOT --> TMP[temp/]
    ROOT --> BAK[backup/]
    ROOT --> SQL[u921830511_school.sql]

    APPDIR --> C1[controllers]
    APPDIR --> C2[models]
    APPDIR --> C3[views]
    APPDIR --> C4[config]
    APPDIR --> C5[libraries]
    APPDIR --> C6[third_party]
```

## 4) Quick Notes

- This is a large CodeIgniter monolith with classic MVC layering.
- Most business surface area is in `application/controllers/admin`, `application/views/admin`, and model files in `application/models`.
- Cross-cutting behavior includes:
  - Maintenance mode hook (`application/hooks/maintenance_hook.php`).
  - Custom framework extensions (`application/core/MY_Controller.php`, `MY_Model.php`).
  - Many payment and messaging integrations in `application/libraries` and `application/third_party`.
