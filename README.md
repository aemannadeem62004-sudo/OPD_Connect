# OPD Connect

> A full-stack web application for digitalizing outpatient department operations — enabling patients to book appointments, track statuses, and receive notifications while giving administrators complete control over departments, doctors, and scheduling.

Built with **PHP (OOP)** · **MySQL via PDO** · **Bootstrap 5**

---

## Features

### Patient Portal
- **Secure authentication** — registration, encrypted passwords, and session-protected login
- **Appointment booking** — browse departments, view available specialists, and submit appointment requests
- **Status tracking** — real-time visibility into appointment states: `Pending`, `Approved`, `Completed`, or `Cancelled`
- **Cancellation** — cancel upcoming appointments directly from the dashboard
- **Notification center** — instant updates whenever a booking status changes

### Admin Panel
- **Departmant management** — create, update, and delete hospital departments
- **Doctor registry** — register doctors, assign specialties, and configure availability schedules
- **Appointment supervision** — review, approve, or cancel incoming patient requests
- **User directory** — view and manage registered patient accounts

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.x (Object-Oriented) |
| Database | MySQL with PDO (prepared statements) |
| Frontend | HTML5, CSS3, Bootstrap 5, FontAwesome 6 |
| Dev Server | Apache + MySQL via XAMPP |

---

## Project Structure

```
OPDconnect/
│
├── admin/                  # Admin management pages
│   ├── dashboard.php
│   ├── departments.php
│   ├── doctors.php
│   ├── appointments.php
│   └── users.php
│
├── user/                   # Patient-facing pages
│   ├── dashboard.php
│   ├── book_appointment.php
│   ├── appointments.php
│   └── notifications.php
│
├── config/
│   └── db.php              # Database connection
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
│
├── index.php               # Public landing page
├── doctors.php             # Public doctor directory
├── departments.php         # Public department listings
└── schedule.php            # Public OPD weekly roster
```

---


## Security

- **SQL injection** — all database queries use PDO parameterized statements; raw input never touches query strings
- **XSS prevention** — dynamic output is wrapped in `htmlspecialchars()` before rendering
- **Session management** — `session_start()` guards all `user/` and `admin/` routes against unauthenticated access

---

