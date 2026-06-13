# MediTrack

Hospital & Clinic Management System built with Laravel, featuring Admin, Doctor, and Patient roles.

## Requirements

- PHP 8.2+
- Composer
- MySQL (or SQLite for local dev)
- Node.js (optional, for frontend assets)

## Setup

```bash
composer install
cp .env.example .env   # if needed
php artisan key:generate

# Configure database in .env (MySQL example):
# DB_CONNECTION=mysql
# DB_DATABASE=meditrack
# DB_USERNAME=root
# DB_PASSWORD=

php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Visit `http://localhost:8000`

## Default Login Credentials

| Role    | Email                  | Password  |
|---------|------------------------|-----------|
| Admin   | admin@meditrack.com    | password  |
| Doctor  | (any seeded doctor)    | password  |
| Patient | (any seeded patient)   | password  |

## Roles

- **Admin** — Manage patients, doctors, and appointments
- **Doctor** — View/confirm appointments, write prescriptions
- **Patient** — Book appointments, upload medical reports, contact admin

## Language Switching

Use the **EN / BN** toggle in the navbar, or visit `/lang/en` or `/lang/bn`.

## API Endpoints (Sanctum)

Base URL: `/api`

| Method | Endpoint              | Auth     |
|--------|-----------------------|----------|
| POST   | /signup               | No       |
| POST   | /login                | No       |
| POST   | /logout               | Bearer   |
| GET    | /patients             | Bearer   |
| POST   | /patients             | Bearer   |
| GET    | /patients/{id}        | Bearer   |
| PUT    | /patients/{id}        | Bearer   |
| DELETE | /patients/{id}        | Bearer   |
| GET    | /appointments         | Bearer   |
| POST   | /appointments         | Bearer   |
| GET    | /appointments/{id}    | Bearer   |
| PUT    | /appointments/{id}    | Bearer   |
| DELETE | /appointments/{id}    | Bearer   |
| GET    | /prescriptions        | Bearer   |
| POST   | /prescriptions        | Bearer   |
| GET    | /prescriptions/{id}   | Bearer   |
| PUT    | /prescriptions/{id}   | Bearer   |
| DELETE | /prescriptions/{id}   | Bearer   |

### API Example

```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@meditrack.com","password":"password"}'

# Use token
curl http://localhost:8000/api/patients \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Maintenance Mode

```bash
php artisan down --secret="bypass-token"
# Visit /bypass-token to bypass
php artisan up
```

## Mail Configuration

For production email, configure Mailtrap or SMTP in `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@meditrack.com
MAIL_FROM_NAME=MediTrack
```

By default, mail is logged to `storage/logs/laravel.log`.
