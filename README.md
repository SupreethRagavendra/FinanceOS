# FinanceOS

FinanceOS is a modern, responsive, full-stack web application designed for financial management. It features a beautifully crafted, SaaS-inspired UI with detailed analytics, full CRUD operations for financial records, and strict Role-Based Access Control (RBAC).

## 🚀 Tech Stack

- **Backend:** Laravel 12
- **Database:** SQLite (Configured in `.env`)
- **Frontend:** Laravel Blade + Custom Plain CSS
- **Authentication:** Laravel Sanctum (Session-based)
- **Charts:** Chart.js (Loaded via CDN)
- **No external UI libraries** (Bootstrap/Tailwind) were used. The theme features a minimal, modern approach utilizing 'DM Sans' with tailored design tokens.

## 👥 Roles & Access Rules

The application uses three distinct roles. Every protected route is enforced via the custom `RoleMiddleware`.

1. **Viewer:** Read-only access to the dashboard and financial records.
2. **Analyst:** View access to records + access to summary and analytics data.
3. **Admin:** Full access. Can create/edit/soft-delete financial records and manage users (create/edit/delete/toggle status).

## 🗂️ Folder Structure Overview

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/                 # Chart.js JSON endpoints (SummaryController)
│   │   │   ├── AuthController.php   # Handles login & logout operations
│   │   │   ├── DashboardController.php
│   │   │   ├── FinancialRecordController.php
│   │   │   └── UserController.php   # Admin-only user management
│   │   └── Middleware/
│   │       └── RoleMiddleware.php   # Enforces exact RBAC matching
│   └── Models/
│       ├── FinancialRecord.php      # Includes money formatting, SoftDeletes
│       └── User.php
├── bootstrap/
│   └── app.php                      # Where the role alias & Sanctum API auth is setup
├── database/
│   ├── migrations/                  # Schema for users & financial_records
│   └── seeders/                     # Populates DB with demo data + ~40 records
├── public/
│   └── css/
│       └── app.css                  # Custom tokenized CSS system (SaaS styling)
├── resources/
│   └── views/
│       ├── auth/                    # login.blade.php
│       ├── dashboard/               # index.blade.php (Charts & Stats)
│       ├── errors/                  # 403.blade.php, 404.blade.php
│       ├── layouts/                 # app.blade.php (Sidebar & Topbar framework)
│       ├── records/                 # index, create, edit forms
│       └── users/                   # Admin user management views
└── routes/
    ├── api.php                      # Sanctum-protected JSON analytics endpoints
    └── web.php                      # Session-protected Web MVC routes
```

## 🛠️ Setup Instructions

1. **Clone or Extract the Project**
   Ensure you are in the application root directory.

2. **Install Composer Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   If a `.env` file does not exist, duplicate the example file:
   ```bash
   cp .env.example .env
   ```
   *Note: SQLite is configured by default in Laravel 12 via `DB_CONNECTION=sqlite`. Ensure you don't overwrite this.*

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seed Database**
   Since SQLite is empty upon initialization, run the following to create the database file, build schemas, and seed demo records.
   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application**
   ```bash
   php artisan serve
   ```
   Navigate to `http://localhost:8000`

---

## 🔐 Available Demo Accounts

All demo accounts use the password: **`password`**

- **Admin Account:** `admin@finance.com` *(Full Control)*
- **Analyst Account:** `analyst@finance.com` *(View + Analytics)*
- **Viewer Account:** `viewer@finance.com` *(View Only)*

---

## 📍 Route Summary & Access Control

### Authentication
| Method | Endpoint | Description | Role Access |
|---|---|---|---|
| GET | `/login` | Show login form | Guest |
| POST | `/login` | Authenticate | Guest |
| POST | `/logout` | Terminate session | Authenticated |

### Dashboard
| Method | Endpoint | Description | Role Access |
|---|---|---|---|
| GET | `/dashboard` | View dashboard & recent records | `viewer`, `analyst`, `admin` |

### Financial Records
| Method | Endpoint | Description | Role Access |
|---|---|---|---|
| GET | `/records` | Browse records with filters | `viewer`, `analyst`, `admin` |
| GET | `/records/create` | Show record creation form | `admin` |
| POST | `/records` | Submit new record | `admin` |
| GET | `/records/{id}/edit` | Show record update form | `admin` |
| PUT | `/records/{id}` | Store updated record data | `admin` |
| DELETE | `/records/{id}` | Soft delete a record | `admin` |

### User Management
| Method | Endpoint | Description | Role Access |
|---|---|---|---|
| GET | `/users` | List system users | `admin` |
| GET | `/users/create` | Show user creation form | `admin` |
| POST | `/users` | Submit new user details | `admin` |
| GET | `/users/{id}/edit` | Show user update form | `admin` |
| PUT | `/users/{id}` | Store updated user data (status/role) | `admin` |
| DELETE | `/users/{id}` | Hard delete user | `admin` |

### API (Analytic Summaries via Fetch)
| Method | Endpoint | Description | Role Access |
|---|---|---|---|
| GET | `/api/summary` | Dashboard stat cards | `auth:sanctum` |
| GET | `/api/category-totals` | Donut chart dataset | `auth:sanctum` |
| GET | `/api/monthly-trends` | Line chart dataset | `auth:sanctum` |

---

## 🎯 Assumptions Made

1. **Sanctum Web Sessions:** Standard `auth:sanctum` is utilized as the guard mechanism, ensuring AJAX `fetch` requests seamlessly authenticate using standard cookies & CSRF tokens over local endpoints.
2. **Chart Colors:** Colors dynamically reflect modern dashboard requirements. Income records inherently translate to `#22c55e` (green), and expenses map to `#ef4444` (red), reinforcing rapid visual assessment.
3. **Soft Deletes Strategy:** Instead of erasing financial data forever, standard Laravel `SoftDeletes` functionality removes the trace globally while still retaining the record history in the raw SQLite schema.
4. **Currency:** To match generic enterprise constraints across certain demographics, amounts are formatted visually as `₹XX,XXX.XX` output, but natively accept generic float submissions.
