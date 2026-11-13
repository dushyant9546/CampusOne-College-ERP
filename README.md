# CampusOne — College ERP Portal (Role-Based Demo)

CampusOne is a responsive college ERP portal prototype built with **HTML5, CSS3, JavaScript, PHP, and JSON file storage**. It provides separate sign-in and role-specific workspaces for students, faculty, and administrators.

## Demo accounts

| Role | Email | Password |
|---|---|---|
| Student | `student@campusone.demo` | `Student@123` |
| Faculty | `faculty@campusone.demo` | `Faculty@123` |
| Admin | `admin@campusone.demo` | `Admin@123` |

These are public demo credentials. Change them before any real deployment.

## Features

### Student
- Personal student dashboard
- Semester, course, and fee summary
- Subject-wise attendance overview
- Weekly timetable
- Campus announcements

### Faculty
- Faculty-specific login and dashboard
- Teaching allocation overview
- Sample attendance register
- Campus announcements

### Administrator
- Separate administrator login and dashboard
- Overview of demo user accounts and academic data
- Publish campus announcements
- Role-based access restrictions for admin-only actions

### Shared
- Responsive interface for desktop, tablet, and mobile
- PHP session login and logout
- Password hashing using PHP `password_hash` / `password_verify`
- Session ID regeneration after login
- CSRF tokens for forms
- JSON-backed sample data

## Requirements
- PHP 8.0+
- XAMPP (Apache) or PHP built-in development server
- Modern browser

## Run with XAMPP
1. Extract `CampusOne_ERP_Pro.zip`.
2. Copy the `CampusOne_ERP_Pro` folder to `C:\\xampp\\htdocs\\`.
3. Open XAMPP Control Panel and start **Apache**.
4. Visit `http://localhost/CampusOne_ERP_Pro/`.
5. Choose Student, Faculty, or Admin and sign in using the demo credentials above.

## Run with PHP's built-in server
Open a terminal in the project directory and run:
```bash
php -S localhost:8000
```
Then visit `http://localhost:8000/`.

## Project structure
```text
CampusOne_ERP_Pro/
├── index.php             # Role-select login page
├── dashboard.php         # Role-based dashboards
├── config.php            # Sessions, helpers, demo data
├── logout.php            # Secure POST logout
├── announcement.php      # Admin-only announcement publishing
├── assets/
│   ├── style.css         # Responsive design system
│   └── app.js            # UI interactions
├── data/
│   └── .htaccess         # Deny direct access where supported
└── README.md
```

## Data and functionality notes
- The app creates `data/users.json` and `data/portal.json` automatically on first run.
- Demo data is fictional/sample data. The student identity shown is project demonstration content.
- Admin can publish announcements; they are saved to the JSON data file.
- Student fee information is display-only. No payment gateway is connected.
- Faculty attendance register is read-only sample data. Attendance editing and official approval workflows are not implemented.
- This prototype does not connect to MySQL or Supabase.

## Important production checklist
This is a learning/demo project, not a production-ready college ERP. Before real use:
1. Move to MySQL/PostgreSQL and use database migrations.
2. Replace public demo credentials with administrator-created accounts and forced password changes.
3. Add password reset, account lockout/rate limiting, audit logs, and secure HTTPS deployment.
4. Enforce authorization on every endpoint and add finer permissions for departments/classes.
5. Add faculty attendance entry, student results, course registration, fee gateway integration, and notifications.
6. Review privacy, backups, validation, logging, and institution-specific policies.
7. Configure web-server rules so JSON data and configuration files cannot be downloaded directly.

## Future scope
- MySQL database integration
- Student/faculty/admin account management
- Faculty attendance marking and approval
- Exam results and assignment management
- Course registration
- Online fee payment integration
- Email/SMS/in-app notifications
- Audit reports and analytics
