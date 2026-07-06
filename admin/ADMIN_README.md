# Gagan Dental & Aesthetics Clinic — Admin Panel

Laravel 12 + Bootstrap 5 admin panel with role-based access (spatie/laravel-permission).
One Laravel app (in `admin/`) powers both the public website and the `/admin` panel.

## Access

Make sure **Apache** and **MySQL** are running in XAMPP, then open:

> http://localhost/GaganDentalAndClininc/admin

(`/admin` redirects to the dashboard, which redirects guests to the login page.)

## Default accounts

| Role        | Email                                | Password      | Access                                   |
|-------------|--------------------------------------|---------------|------------------------------------------|
| Super Admin | superadmin@gagandentalclinic.com     | `Super@12345` | Everything (bypasses all checks)         |
| Admin       | admin@gagandentalclinic.com          | `Admin@12345` | All content modules (no role management) |

> Change these passwords after first login (Users module).

## Roles & permissions

- **super-admin** — full access to every module (enforced via `Gate::before`).
- **admin** — all content/back-office modules except role management.
- **receptionist** — front-desk access: `view dashboard`, `manage appointments`, `manage messages`.

Create more roles/permissions from the **Roles & Permissions** module.

## Modules

- **Dashboard** — at-a-glance stats (appointments, messages, treatments, doctors, etc.) + recent appointment requests.
- **Appointments** — booking requests from the website; view details and move through statuses (new → contacted → confirmed → completed / cancelled).
- **Treatments** & **Treatment Categories** — the clinic's services, with image galleries and pricing.
- **Doctors** — the clinical team (photo, designation, qualifications, bio).
- **Offers** — promotional offers shown on the website.
- **Testimonials**, **Features**, **Blogs**, **Pages** — marketing content.
- **Hero / About sections** — homepage content blocks.
- **Messages** & **Subscribers** — contact-form enquiries and newsletter signups.
- **Email Templates** — editable transactional emails (contact + appointment).
- **Users**, **Roles & Permissions**, **Company Info** — administration.

## Database

- Connection: MySQL (`mysql`), database **`GaganDentalAndClininc`**, user `root`, no password (XAMPP default).
- Configured in `admin/.env`.

## Common commands

```bash
cd admin
php artisan migrate:fresh --seed   # rebuild DB + reseed roles/users/company/content
php artisan storage:link           # (already run) link public/storage for uploads
php artisan serve                  # optional: run at http://127.0.0.1:8000
```

> For shared hosting where symlinks don't survive upload, open `/_fix_links.php`
> once in the browser to (re)create the `storage` and `assets` links, then delete it.
