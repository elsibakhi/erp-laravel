# Simple ERP System (Laravel 12, Multi-Tenant)

A lightweight ERP system built with **Laravel 12**, designed for **multi-tenancy** using 
[spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy).  
The project follows a **Domain-driven architecture** and provides a clean **API-first** backend 
for managing business operations.

---

## ✨ Features

- 🔑 **Multi-tenant architecture** (each tenant has its own database).  
- 🌐 **Domain-driven structure** for modular ERP design.  
- 📡 **RESTful API endpoints** for all modules.
  
📊 **Core ERP Modules:**

- **Authentication** – Secure login, roles, and permissions management.
- **Departments** – Organize employees into structured departments.
- **Employees** – Manage employee profiles, job titles, salaries, and statuses.
- **Leave** – Handle leave requests (annual, sick, unpaid) with approvals.
- **Projects** – Track projects, milestones, and overall statuses.
- **Finance** – Manage invoices, expenses, and financial records.
- **Tenant** – Multi-tenant support for managing separate organizations.
 

---

## 🏗️ Tech Stack

- **Backend:** Laravel 12  
- **Multi-Tenancy:** spatie/laravel-multitenancy  
- **Database:** MySQL (separate DB per tenant)  
- **Auth:** Laravel Breeze / Sanctum (API authentication)  
- **Architecture:** Domain-based modular structure  

---

📂 **Project Structure** 
```text
app/
├── Domains/
│ ├── Authentication/
│ ├── Department/
│ ├── Employee/
│ ├── Finance/
│ ├── Leave/
│ ├── Project/
│ └── Tenant/
└── ...


  
