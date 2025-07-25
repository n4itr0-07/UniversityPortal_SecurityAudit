<?php
include('config.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Store contact messages directly without sanitization & Display back - vulnerability demonstration
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // You can optionally save them to a DB or file, but here we'll just show a confirmation with reflected input (XSS vulnerability)
    $confirmation = "Thank you, $name, for contacting us! We will reach you at $email.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Mint University</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 470px; margin: 55px auto 70px auto; background: #fff;
            padding: 35px 28px; border-radius: 12px; box-shadow: 0 2px 18px #0002;
        }
        h2 {
            color: #0c3b6c; font-weight: 700; margin-bottom: 20px; text-align: center;
        }
        label {
            font-weight: 600; color: #23598c; display: block; margin-top: 16px;
        }
        input[type=text], input[type=email], textarea {
            width: 100%; padding: 10px 14px; margin-top: 6px;
            border-radius: 7px; border: 1.8px solid #0c3b6caa; font-size: 1.03em;
            box-sizing: border-box; transition: border-color 0.3s ease;
            font-family: Arial, sans-serif;
        }
        input[type=text]:focus, input[type=email]:focus, textarea:focus {
            border-color: #467ee8; outline: none;
        }
        textarea {
            min-height: 100px; resize: vertical;
        }
        button {
            margin-top: 24px; width: 100%; background: #0c3b6c; border: none;
            border-radius: 8px; padding: 12px 0; font-weight: 700; color: white;
            font-size: 1.1em; cursor: pointer; transition: background 0.3s ease;
        }
        button:hover {
            background: #3461a8;
        }
        .confirmation {
            margin-top: 20px; font-size: 1.05em; font-weight: 600; text-align: center; color: #268b01;
            padding: 12px; background: #defbdc; border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Contact Us</h2>
    <form method="POST" action="">
        <label for="name">Your Name:</label>
        <input id="name" name="name" type="text" required />

        <label for="email">Your Email:</label>
        <input id="email" name="email" type="email" required />

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send Message</button>
    </form>

    <?php if(isset($confirmation)) {
        // Vulnerable reflected outputs (stored/reflect XSS possible)
        echo "<div class='confirmation'>$confirmation</div>";
    } ?>
</div>
</body>
</html>
