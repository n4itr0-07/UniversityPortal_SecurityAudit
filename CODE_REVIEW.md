# Vulnerability Demonstration & Secure Coding Guide

This document illustrates key **vulnerabilities** found in the *Vulnerable University Portal* project, providing **vulnerable code snippets** followed by **secure remediation examples** and detailed explanations. The goal is to guide effective understanding and remediation of common web security flaws.

---

## 1. SQL Injection (SQLi)

### Vulnerable Code (e.g., `login.php`)

```php
<?php 
// Vulnerable: direct interpolation of user inputs into SQL query
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

```

### ⚠️Risk

- Attackers can inject SQL code through inputs, bypass authentication or alter database

### 🔐 Secure Code (Prepared Statements & Password Hashing)

```php
<?php 
// Use prepared statements with parameter binding
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verify hashed password
    if (password_verify($password, $user['password'])) {
        // Authentication successful
        $_SESSION['user'] = $username;
    } else {
        echo "Invalid credentials";
    }
} else {
    echo "Invalid credentials";
}

$stmt->close();

```

### Explanation

- Using **prepared statements** prevents injection.
- Passwords must be stored hashed (`password_hash()` during registration).
- Use `password_verify()` to check hashed passwords securely.

---

## 2. Cross-Site Scripting (XSS)

### Vulnerable Code (e.g., `feedback.php` displaying feedback)

```php
<?php 
// Stored XSS: feedback displayed without escaping
while($row = mysqli_fetch_assoc($res)) {
    echo "<li>" . $row['comment'] . "</li>"; // no sanitization -> XSS
}

```

### Risk

- An attacker can inject JavaScript which executes in browsers of other users.

### Secure Code (Output Encoding)

```php
<?php 
while ($row = mysqli_fetch_assoc($res)) { 
    // Encode output to prevent script execution
    echo "<li>" . htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8') . "</li>"; 
} 
?>

```

### XSS Explanation

- `htmlspecialchars()` converts special characters to HTML entities, mitigating XSS.
- Always escape output rendered on the client side, especially user-generated content.

---

## 3. Cross-Site Request Forgery (CSRF)

### Vulnerable Code (e.g., `feedback.php`)

```php

   <form method="POST" action="">
    <textarea name="feedback"></textarea>
    <button type="submit">Submit</button>
</form>
// No CSRF token verification in PHP POST handler

```

### Risk⁂

- An attacker can forge a POST request causing the victim to submit unwanted feedback.

### Secure Code (Add CSRF Tokens)

**HTML Form:**

```php

<?php 
session_start(); 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token']; 
?>

<form method="POST" action="">
    <textarea name="feedback"></textarea>
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>" />
    <button type="submit">Submit</button>
</form>

```

**PHP Processing:**

```php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid CSRF token');
    }

    $feedback = $_POST['feedback'];
    // Proceed with safe insertion, e.g., prepared statements
}

```

### Explanation⁜

- CSRF tokens are unique per session and verified before processing forms.
- This defends against unauthorized form submissions by third-party sites.

---

## 4. Insecure Direct Object Reference (IDOR)

### Vulnerable Code (e.g., `admin.php` deleting users directly)

```php
<?php
// No authentication or authorization checking
if (isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
}
?>

```

### IDOR Risk

- Any user can delete any user account by manipulating the `delete_user_id` parameter.

### Secure Code (Authentication & Authorization Checks)

```php
<?php
session_start();
if (!isset($_SESSION['user']) || !$_SESSION['is_admin']) {
    die("Access denied");
}

if (isset($_GET['delete_user_id'])) {
    $user_id = intval($_GET['delete_user_id']); // sanitize input
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}
?>

```

### A&A Explanation

- Enforce authentication and verify user role before allowing deletion.
- Sanitize input and use prepared statements.
- Prevents unauthorized user manipulation.

---

## 5. Unrestricted File Upload

### Vulnerable Code (e.g., `upload.php`)

```php
<?php
move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $_FILES['file']['name']);
?>


```

### File Upload Risk

- Allows uploading of arbitrary files (including executable PHP files), leading to remote code execution.

### Secure Code (File Type Restrictions & File Name Sanitization)

```php
<?php
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$file_type = mime_content_type($_FILES['file']['tmp_name']);

if (!in_array($file_type, $allowed_types)) {
    die("Invalid file type.");
}

$baseName = basename($_FILES['file']['name']);
$target_dir = "uploads/";
$target_file = $target_dir . uniqid() . "-" . preg_replace('/[^a-zA-Z0-9\._-]/', '', $baseName);

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
    echo "File uploaded successfully.";
} else {
    echo "Upload failed.";
}
?>

```

### Explanation👇

- Check MIME type to ensure only images are accepted.
- Sanitize filenames and add random unique prefixes to prevent overwriting.
- Prevent PHP or other executable files from being uploaded and run.

---

## 6. Sensitive Information Disclosure

### Vulnerable Setup (e.g., `backup/config_backup.txt` publicly accessible)

- Storing database credentials and secrets in a publicly accessible folder.

### Secure Handling

- **Do NOT place sensitive credentials or backups inside the web root directory.**  
- Move such files outside the document root or protect access using server configuration.

**Example `.htaccess` to block public access inside `/backup/`:**

```git
Order Allow,Deny
Deny from all
```

Alternatively, restrict access via Apache config or firewall.

---

## Summary Table of Vulnerabilities & Secure Practices

| Vulnerability               | Location (File)    | Vulnerable Practice                 | Secure Practice                                       |
|-----------------------------|--------------------|-----------------------------------|------------------------------------------------------|
| SQL Injection               | `register.php`, `login.php`, `news.php`, `admin.php` | Direct SQL with unsanitized inputs | Use prepared statements, parameterized queries       |
| Cross-Site Scripting (XSS)  | `feedback.php`, `news.php`, `contact.php`, `profile.php` | Output user inputs without escaping | Use `htmlspecialchars()` to encode output            |
| Cross-Site Request Forgery (CSRF) | `feedback.php`           | Forms without CSRF tokens          | Implement CSRF tokens and verify in POST processing  |
| Insecure Direct Object Reference (IDOR) | `admin.php`             | No authorization checks on user actions | Enforce authentication and role-based authorization  |
| Unrestricted File Upload    | `upload.php`        | Accept all file types, no validation | Restrict file types, sanitize filenames, store securely |
| Sensitive Information Disclosure | `backup/config_backup.txt` | Store secrets in public folder    | Move secrets outside web root; restrict access        |

---

## Final Notes

- Always keep your **prepared statements**, **escaping output**, **access controls**, and **input validation** as pillars of secure web app development.
- Regularly audit your codebase for similar patterns.
- Never deploy vulnerable code to production.
- Use this repository as a **learning tool to identify and fix security flaws**.

---

**This completes the demonstration and secure guidance on your university portal project vulnerabilities.**  
Feel free to reuse, expand, or adapt these examples for your audit and remediation reports.  
Happy securing! 🛡️
