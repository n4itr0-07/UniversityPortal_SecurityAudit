<?php
include('config.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Mint University</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { font-family: Arial, sans-serif; background: #f3f6fb; }
        .container {
            max-width: 730px; margin: 40px auto; background: #fff;
            border-radius: 12px; padding: 30px 28px; box-shadow: 0 2px 18px rgba(0,0,0,0.12);
        }
        h2 {
            color: #0c3b6c; font-weight: 700; margin-bottom: 16px;
        }
        .welcome {
            font-size: 1.45em; margin-bottom: 12px; color: #23598c;
        }
        .links a {
            margin-right: 24px; color: #467ee8; font-weight: 600;
            text-decoration: none; font-size: 1.1em;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .stats {
            margin-top: 24px; font-size: 1.1em;
            color: #2a2f36;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Dashboard</h2>
    <div class="welcome">
        Welcome, <?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest'; ?>!
    </div>
    <div class="links">
        <a href="profile.php">Profile</a>
        <a href="courses.php">Courses</a>
        <a href="faculty.php">Faculty</a>
        <a href="news.php">News</a>
        <a href="feedback.php">Feedback</a>
        <a href="upload.php">Upload Profile Pic</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="stats">
        <p>You are currently enrolled in <b>5</b> courses.</p>
        <p>Last login: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>
</div>
</body>
</html>
