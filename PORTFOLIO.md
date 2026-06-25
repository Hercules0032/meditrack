# MediTrack — Hospital & Clinic Management System

A full-stack, role-based hospital management platform built with **Laravel 13 / PHP 8.4**.
MediTrack digitizes the core clinic workflow — patients book appointments, doctors confirm
them and issue prescriptions, and administrators oversee the entire operation — behind a
secure, multi-role access system and a token-authenticated REST API.

## Overview

MediTrack models a real clinic with three distinct user roles, each with its own dashboard,
permissions, and workflow. The application enforces strict separation between roles using
custom middleware, exposes both a server-rendered web UI and a RESTful JSON API, and ships
with email notifications, custom validation, and English/Bengali localization.

## Key Features

- **Role-based access control** — Admin, Doctor, and Patient roles isolated by dedicated
  middleware (`IsAdmin`, `IsDoctor`, `IsPatient`); each role is routed to its own dashboard
  and blocked (HTTP 403) from areas outside its scope.
- **Appointment lifecycle** — Patients book appointments with a chosen doctor; doctors review
  and confirm them; confirmation triggers an email to the patient. Status flows through
  pending → confirmed → cancelled.
- **Prescriptions** — Doctors issue prescriptions against confirmed appointments; patients
  view them from their portal, with a "prescription ready" email notification.
- **Medical records** — Patients upload and manage their own medical reports.
- **Admin operations** — Full management of patients, doctors, and appointments, including
  bulk actions and appointment status overrides.
- **REST API (Laravel Sanctum)** — Token-authenticated endpoints for signup/login and
  CRUD over patients, appointments, and prescriptions, enabling mobile or third-party clients.
- **Internationalization** — Live English ⇄ Bengali language switching with session
  persistence.
- **Custom validation rules** — Domain-specific rules such as `FutureDate` (appointments must
  be in the future) and `FutureAdultAge`.
- **Email notifications** — Mailable classes for appointment confirmations and prescription
  readiness.

## Tech Stack

| Layer            | Technology                                              |
|------------------|---------------------------------------------------------|
| Backend          | Laravel 13, PHP 8.4                                      |
| Authentication   | Session auth (web) + Laravel Sanctum tokens (API)       |
| Frontend         | Blade templates, Bootstrap 5, Bootstrap Icons           |
| Database         | MySQL / SQLite, Eloquent ORM                            |
| Tooling          | Composer, Vite, Laravel Pint, PHPUnit                   |

## Architecture Highlights

- **Domain-organized controllers** — namespaced by role (`Admin/`, `Doctor/`, `Patient/`)
  and channel (`Api/`) for clear separation of concerns.
- **Eloquent relationships** — `User → Patient/Doctor`, `Appointment → Doctor/Patient`,
  `Prescription → Appointment`, `Patient → MedicalReport`.
- **Seeders & factories** — generate a realistic demo dataset (admin, doctors, patients,
  and appointments) for instant local evaluation.
- **Feature-tested workflows** — core flows such as patient-booking visibility to the
  assigned doctor are covered by automated tests.

## Roles at a Glance

| Role    | Capabilities                                                              |
|---------|--------------------------------------------------------------------------|
| Admin   | Manage doctors, patients, and appointments; bulk actions; status control |
| Doctor  | View/confirm appointments, issue prescriptions, see assigned patients    |
| Patient | Book appointments, upload medical reports, view prescriptions, contact   |

---

**Repository:** https://github.com/Hercules0032/meditrack
