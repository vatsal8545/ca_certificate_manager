# CA Certificate Manager

A PHP/MySQL CA certificate management system with multi-tenant CA users and a separate administrator panel.

## New Features

- Multi-tenant CA support: each CA user sees only their own clients, firm settings, and certificates.
- Administrator role: separate admin panel for managing CA accounts, site settings, and dashboard stats.
- Secure authentication: session-based login and PHP `password_hash` encryption.
- Login and registration pages now use the landing page flow.
- Database-backed persistence in MySQL through `database/db.php`.
- Certificate generation and PDF export based on CA client data.

## Default admin login

- Username: `admin`
- Password: `admin123`

## Key Pages

- `home.php` — Landing page with links to login/register
- `login.php` — Sign in page
- `register.php` — CA registration page
- `index.php` — CA dashboard and certificate generator
- `firm_settings.php` — CA user firm settings
- `profile.php` — View and manage current user profile
- `admin/index.php` — Administrator dashboard
- `admin/users.php` — Manage CA user accounts
- `admin/settings.php` — Update site settings

## Setup

1. Place the project in your Laragon `www` folder, for example:
   - `C:\laragon\www\ca_certificate`
2. Start Laragon and the MySQL server.
3. Open the app in your browser:
   - `http://localhost/ca_certificate/home.php`
4. Use the default admin credentials to log in, or register a new CA user.

## Database

- The database is automatically created as `ca_certificate_manager`.
- All user, client, firm, and certificate data is stored in MySQL.
- The app uses `database/db.php` to initialize tables and manage data.

## Notes

- CA registration blocks reserved credentials like `admin` / `admin123`.
- Admin accounts are managed separately and cannot be created through the CA registration form.
- The landing page now directs users to login/register from `home.php`.

## How to Use

1. Open `http://localhost/ca_certificate/home.php`
2. Click `Login` to sign in, or `Register` to create a new CA account.
3. CA users can add clients, configure firm settings, and generate certificates.
4. Administrators can manage CA users and update site configuration.

## Future improvements

- Add password reset flow.
- Add certificate history and audit logs.
- Enhance PDF certificate designs.
- Add email notifications and download tracking.
  
