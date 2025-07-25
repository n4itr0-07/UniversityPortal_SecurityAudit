<?php
include('config.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST") {
    // SQL Injection + plaintext password vulnerabilities
    $sql = "SELECT * FROM users WHERE username='$_POST[username]' AND password='$_POST[password]'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) == 1) {
        $_SESSION['user'] = $_POST['username'];
        header("Location: index.php?message=Logged in!");
        exit();
    } else {
        $error = "Incorrect username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; }
        .container {
            max-width: 400px;
            margin: 50px auto 70px auto;
            padding: 30px 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 20px #0002;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #0c3b6c;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 700;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #23598c;
            font-weight: 600;
            font-size: 1em;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 9px 10px;
            margin-top: 5px;
            border: 1.7px solid #0c3b6caa;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type=text]:focus, input[type=password]:focus {
            border-color: #467ee8;
            outline: none;
        }
        button {
            width: 100%;
            margin-top: 25px;
            background: #0c3b6c;
            color: white;
            font-weight: 700;
            font-size: 1.1em;
            border: none;
            padding: 12px 0;
            border-radius: 7px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #3461a8;
        }
        .error-msg {
            margin-top: 15px;
            text-align: center;
            color: #d13438;
            font-weight: 600;
            font-size: 0.95em;
        }
        .info-text {
            margin-top: 14px;
            color: #2a2f36cc;
            font-size: 0.925em;
            text-align: center;
        }
        .info-text a {
            color: #0c3b6c;
            text-decoration: none;
            font-weight: 600;
        }
        .info-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login to Your Account</h2>
    <form method="POST" action="">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="Your username" required />

        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="Your password" required />

        <button type="submit">Log In</button>
    </form>
    <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
    <div class="info-text">
        Don't have an account? <a href="register.php">Register now</a>.
    </div>
</div>

</body>
</html>
