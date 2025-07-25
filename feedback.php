<?php
include('config.php');
session_start();
if($_SERVER['REQUEST_METHOD'] == "POST") {
    // CSRF & Stored XSS vulnerability (no sanitization)
    $feedback = $_POST['feedback'];
    mysqli_query($conn, "INSERT INTO feedback (comment) VALUES ('$feedback')");
    $msg = "Thank you for your feedback!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Feedback - Mint University</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 700px;
            margin: 40px auto 70px auto;
            padding: 28px 26px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 20px #0002;
        }
        h2 {
            color: #0c3b6c;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }
        form textarea {
            width: 100%;
            min-height: 100px;
            resize: vertical;
            padding: 14px 12px;
            font-size: 1.1em;
            border-radius: 7px;
            border: 1.8px solid #0c3b6ca0;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        form textarea:focus {
            border-color: #467ee8;
            outline: none;
        }
        form button {
            margin-top: 15px;
            background: #0c3b6c;
            color: #fff;
            font-weight: 700;
            font-size: 1.1em;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #3461a8;
        }
        .msg {
            text-align: center;
            margin-top: 14px;
            font-weight: 600;
            color: #268b01;
            font-size: 1.03em;
        }
        .feedback-list {
            margin-top: 35px;
            max-height: 250px;
            overflow-y: auto;
            border-top: 1px solid #ddd;
            padding-top: 12px;
        }
        .feedback-list li {
            margin-bottom: 14px;
            background: #f5f8ff;
            border-radius: 6px;
            padding: 10px 14px;
            box-shadow: 0 1px 5px #00000010;
            color: #2b2b2b;
            font-size: 1.02em;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Course Feedback</h2>
    <form method="POST" action="">
        <textarea name="feedback" placeholder="Write your feedback here..." required></textarea><br>
        <button type="submit">Submit Feedback</button>
    </form>
    <?php if(isset($msg)) echo "<div class='msg'>$msg</div>"; ?>

    <h3>Recent Feedbacks</h3>
    <ul class="feedback-list">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM feedback ORDER BY id DESC LIMIT 15");
        while($row = mysqli_fetch_assoc($res)) {
            // Stored XSS vulnerability left in place as requested
            echo "<li>" . $row['comment'] . "</li>";
        }
        ?>
    </ul>
</div>

</body>
</html>
