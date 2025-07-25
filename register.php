<?php
include('config.php');
if($_SERVER['REQUEST_METHOD'] == "POST") {
    // SQL Injection vulnerability
    $sql = "INSERT INTO users (username, password) VALUES ('$_POST[username]', '$_POST[password]')";
    mysqli_query($conn, $sql);
    header("Location: index.php?message=Registration successful!");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; }
        .container {
            max-width: 400px;
            margin: 50px auto 60px auto;
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
    <h2>Create a New Account</h2>
    <form method="POST" action="">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" placeholder="Choose username" required />

        <label for="password">Password</label>
        <input id="password" name="password" type="password" placeholder="Enter password" required />

        <button type="submit">Register</button>
    </form>
    <div class="info-text">
        Already have an account? <a href="login.php">Login here</a>.
    </div>
</div>

</body>
</html>
