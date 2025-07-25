<?php
include('config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        /* Extra styles for visual upgrade */
        body {
            background: linear-gradient(to bottom right, #e7eaf6, #f3f6fb 80%);
        }
        .header-main {
            background: linear-gradient(90deg,#0c3b6c,#467ee8);
            padding: 32px 16px 24px 16px;
            color: #fff;
            text-align: center;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 2px 16px 0px #0001;
            margin-bottom: 40px;
        }
        .header-main h1 {
            margin: 0 0 8px 0;
            font-size: 2.8em;
            letter-spacing: 2px;
        }
        .header-main .subtitle {
            font-size: 1.2em;
            letter-spacing: 1.5px;
            opacity: .95;
        }
        .nav-bar {
            margin: 20px 0 0 0;
        }
        .nav-bar a {
            display: inline-block;
            margin: 8px 22px 0 0;
            color: #c7e0ff;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.07em;
            padding: 4px 12px;
            border-radius: 5px;
            transition: 0.18s;
        }
        .nav-bar a:hover { background: #1c57af; color: #fff; }
        .main-content {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 32px 24px 28px 24px;
            box-shadow: 0 2px 18px 0px #0002;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px 12px;
            margin: 34px 0 24px 0;
            justify-content: center;
        }
        .feature-card {
            flex: 1 1 220px;
            min-width: 180px;
            background: #f5f8ff;
            border-radius: 8px;
            box-shadow: 0 1px 6px 0px #0001;
            padding: 16px;
            text-align: center;
        }
        .feature-card h3 {
            margin-top: 0;
            margin-bottom: 7px;
            color: #23598c;
        }
        .feature-card p {
            margin: 0;
            font-size: 1.05em;
            color: #2a2f36;
            opacity: .93;
        }
        .welcome-big {
            font-size: 1.7em;
            color: #173965;
            font-weight: 600;
            text-align: center;
            margin-bottom: 8px;
        }
        .slogan {
            text-align: center;
            margin-top: -6px;
            font-size: 1.13em;
            color: #3a4d6f;
            opacity: .8;
        }
        .homepage-footer {
            color: #88a6d9;
            text-align: center;
            font-size: 1em;
            margin: 54px 0 12px 0;
        }
        .logo-mockup {
            background: #fff2;
            display: inline-block;
            border-radius: 50%;
            border: 3px solid #fff5;
            padding: 10px 13px 6px 13px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <header class="header-main">
        <div class="logo-mockup">
            <!-- You can replace this with an actual <img src="..."> for a real logo -->
            <svg width="36" height="36" viewBox="0 0 52 52" fill="none"><ellipse cx="26" cy="26" rx="24" ry="24" fill="#e9f0fd"/><ellipse cx="26" cy="26" rx="18" ry="10" fill="#d0e2ff"/><text x="14" y="33" fill="#23598c" font-family="Arial" font-size="22" font-weight="bold">U</text></svg>
        </div>
        <h1>Mint University Portal</h1>
        <div class="subtitle">Your gateway to everything campus</div>
        <nav class="nav-bar">
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="faculty.php">Faculty</a>
            <a href="courses.php">Courses</a>
            <a href="contact.php">Contact</a>
            <a href="feedback.php">Course Feedback</a>
            <a href="news.php">News</a>
            <a href="upload.php">Profile Upload</a>
            <a href="profile.php">Profile</a>
            <a href="admin.php">Admin</a>
        </nav>
    </header>

    <section class="main-content">
        <div class="welcome-big">
            Welcome to Mint University's Student Portal!
        </div>
        <div class="slogan">
            Explore your courses, stay updated with campus news, connect and engage – all in one place.
        </div>

        <?php
        // Reflected XSS vulnerability LEFT as per your demo environment
        if(isset($_GET['message'])) {
            echo "<div style='margin:16px auto 6px auto;color:#268b01;font-weight:500;font-size:1.1em;text-align:center;'>" . $_GET['message'] . "</div>"; // Vulnerable!
        }
        ?>

        <div class="features">
            <div class="feature-card">
                <h3>&#128272; Secure Login</h3>
                <p>Sign in to access your personalized dashboard, update your profile, and join campus discussions.</p>
            </div>
            <div class="feature-card">
                <h3>&#128218; Course Feedback</h3>
                <p>Share your feedback and help shape the learning experience. Every voice counts in continuous improvement.</p>
            </div>
            <div class="feature-card">
                <h3>&#128197; Campus News</h3>
                <p>Stay informed on important dates, announcements and events happening at Mint University.</p>
            </div>
            <div class="feature-card">
                <h3>&#128228; File Uploads</h3>
                <p>Upload and manage your profile image and essential documents easily and securely.</p>
            </div>
        </div>

        <div style="text-align:center;margin-top:20px;">
            <span style="font-size:1.14em;color:#0c3b6c;font-weight:500;">★ Get started by registering or logging in! ★</span>
        </div>
    </section>

    <div class="homepage-footer">
        &copy; <?php echo date("Y"); ?> Mint University. For academic demonstration only.
    </div>
</body>
</html>
