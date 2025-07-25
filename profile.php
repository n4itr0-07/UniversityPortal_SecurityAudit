<?php
include('config.php');
session_start();

// For demo: no authentication enforcement (vulnerable)
$username = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';

// For demo: no DB update or user info storage, only simulate "profile"
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 500px; margin: 40px auto; padding: 30px 30px;
            background: #fff; border-radius: 14px; box-shadow: 0 2px 24px rgba(0,0,0,0.12);
        }
        h2 {
            color: #0c3b6c; font-weight: 700; margin-bottom: 24px; text-align: center;
        }
        .profile-info {
            font-size: 1.05em; color: #23598c;
            margin-bottom: 22px;
        }
        label {
            font-weight: 600; display: block; margin-top: 16px;
            color: #23598c;
        }
        input[type=text], input[type=email] {
            width: 100%; padding: 9px 12px; border-radius: 7px;
            border: 1.8px solid #0c3b6caa; font-size: 1em; margin-top: 6px;
            box-sizing: border-box; transition: border-color 0.3s ease;
            font-family: Arial, sans-serif;
        }
        input[type=text]:focus, input[type=email]:focus {
            border-color: #467ee8; outline: none;
        }
        button {
            margin-top: 28px; background: #0c3b6c; color: white;
            font-weight: 700; font-size: 1.1em; border: none;
            padding: 12px 0; width: 100%;
            border-radius: 7px; cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #3461a8;
        }
        .note {
            font-size: 0.9em; color: #666; text-align: center; margin-top: 14px;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Profile</h2>
    <div class="profile-info">Logged in as: <b><?php echo $username; ?></b></div>

    <form method="POST" action="">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo $username; ?>" />

        <label for="email">Email (not stored)</label>
        <input type="email" id="email" name="email" placeholder="your.email@example.com" />

        <button type="submit">Update Profile</button>
    </form>

    <div class="note">* Note: Profile updates not saved in demo version.</div>
</div>
</body>
</html>
