# **Vulnerable University Portal - Security Audit Demo**

## Overview

The **Vulnerable University Portal** is a deliberately insecure PHP/MySQL web application designed for educational purposes.  
It demonstrates common web vulnerabilities, including SQL Injection, Cross-Site Scripting (XSS), Insecure Direct Object References (IDOR), unrestricted file uploads, CSRF, and sensitive information leakage.

This project aims to help developers, security enthusiasts, and interns learn how to **identify, exploit, and remediate** typical web application security flaws through hands-on experience.

---

## Demo Video



https://github.com/user-attachments/assets/2e0a17a3-15e7-49a1-a90f-2e7bbe4c3cc8



---

## Features

- Student registration and login (with SQL Injection vulnerability)
- Student dashboard and profile pages (lacking proper access control)
- Course feedback system (with stored XSS and CSRF flaws)
- News board and search (vulnerable to reflected XSS and SQL Injection)
- Admin panel with user management and IDOR vulnerability
- Profile picture upload allowing arbitrary file uploads
- Exposed backup files simulating sensitive data disclosure
- Contact form vulnerable to stored/reflected XSS

---

## Prerequisites

To run this project locally, ensure you have:

- **A Linux-based OS** (Ubuntu/Debian/Linux Mint recommended) or compatible environment with Apache, MySQL, and PHP installed.
- Basic knowledge of PHP and MySQL.
- Administrative privileges to install and start services.

---

## Setup Instructions

Follow these steps to clone, configure, and run the application:

### 1. Clone the Repository

```bash
git clone https://github.com/n4itr0-07/CodeAlpha_UniversityPortal_SecurityAudit.git
cd CodeAlpha_UniversityPortal_SecurityAudit
```

### 2. Install Required Services (Apache, MySQL, PHP)

If not installed, run:

#### On Ubuntu/Linux Mint/Debian

```sh
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysqli php-curl php-xml php-mbstring php-zip
```

### 3. Start Apache and MySQL Services

```sh
sudo systemctl start apache2
sudo systemctl start mysql
```

Enable to start on boot:

```sh
sudo systemctl enable apache2
sudo systemctl enable mysql
```

### 4. Setup MySQL Database

Login to MySQL shell:

```sh
sudo mysql
```

Run the following commands to create the database and tables:

```sql
CREATE DATABASE university_site;
USE university_site;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    comment TEXT NOT NULL
);

CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL
);

INSERT INTO news(title, content) VALUES 
('Welcome to University', 'Our new semester is starting soon!'),
('Exam Notice', 'Midterm exam dates have been published.');
```

Exit MySQL prompt:

```sql
exit;
```

### 5. Configure the Application

- Update **`config.php`** with your MySQL credentials. Example:

```php
<?php $conn = mysqli_connect("localhost", "root", "your_mysql_password", "university_site") or die("DB Connection Failed!"); ?>
```

- Adjust file and folder permissions to ensure the web server can read/write where necessary:

```sh
sudo chown -R www-data:www-data /var/www/html/Vulnerable-University-Portal-Security-Audit
sudo chmod -R 755 /var/www/html/Vulnerable-University-Portal-Security-Audit
```

### 6. Move or Serve the Project Files

- You can copy or symbolically link this project directory to Apache’s default web root:

```sh
sudo ln -s /path/to/Vulnerable-University-Portal-Security-Audit /var/www/html/university-portal
```

- Access the app via browser at:

```sh
http://localhost/university-portal/
```

### 7. Testing

- Use the web interface to register new users, login, submit feedback.
- Explore admin functionalities and note lack of authentication/authorization.
- Try uploading files, perform searches to test vulnerabilities.

---

## Known Vulnerabilities and How to Identify Them

| Page/Feature          | Vulnerability Type             | Description                            |
|----------------------|-------------------------------|--------------------------------------|
| Register/Login        | SQL Injection                 | Unsanitized user input in SQL queries |
| Feedback Form         | Stored XSS & CSRF             | User feedback stored and displayed without sanitization |
| News Search           | Reflected XSS, SQL Injection  | Search input reflected and used unsafely in SQL |
| Admin Panel           | IDOR, Authorization Bypass   | No access control on user deletion   |
| File Upload           | Unrestricted file upload      | No file type or content validation   |
| Backup Configuration  | Sensitive Information Exposure| Publicly accessible backup files     |
| Profile & Dashboard   | Missing Authentication       | Access without session validation    |

---

## Recommendations for Secure Coding & Remediation

- Use **prepared statements with parameterized queries** to prevent SQL injection.
- Implement **input validation and output encoding** to avoid XSS.
- Use **CSRF tokens** on all forms that change state.
- Restrict **file upload types and sizes**, sanitize filenames, and store files securely.
- Apply proper **user authentication and role-based authorization** checks.
- Secure **sensitive configuration files** with proper permissions or move them outside the webroot.
- Regularly update your server software and apply security patches.

---

**Happy Hacking & Learning!**
