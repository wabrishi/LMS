# Learning Management System (LMS)

This is a simple Learning Management System (LMS) built with PHP and MySQL.

## Features

- User Authentication & Roles (Admin, Teacher, Student)
- Course Management
- Student Enrollment
- Lesson Management with YouTube Video Embedding

## Setup

1.  **Configure Database:**
    Open `config/database.php` and update the database credentials (`DB_SERVER`, `DB_USERNAME`, `DB_PASSWORD`, `DB_NAME`).

2.  **Run Setup Script:**
    Execute the `setup.php` script from your terminal to create the database, tables, and import initial data.
    ```bash
    php setup.php
    ```

3.  **Default Login Credentials:**
    - **Admin:**
        - Username: `admin`
        - Password: `password`
    - **Teacher:**
        - Username: `teacher`
        - Password: `password`
    - **Student:**
        - Username: `student`
        - Password: `password`

## How to Run

1.  Place the project files in your web server's document root (e.g., `/var/www/html` or `htdocs`).
2.  Start your web server (e.g., Apache).
3.  Access the application in your web browser (e.g., `http://localhost/public/login.php`).
