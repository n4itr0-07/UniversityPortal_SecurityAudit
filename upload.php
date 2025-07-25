<?php
// Unrestricted file upload (for demo: intentionally vulnerable)
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $target = "uploads/" . $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $target);
    $msg = "Your profile picture was uploaded!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Profile Picture - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 430px;
            margin: 55px auto 60px auto;
            padding: 35px 30px 30px 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 18px #0002;
            text-align: center;
        }
        h2 {
            color: #0c3b6c;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .desc {
            color: #2a2f36bb;
            font-size: 1em;
            margin-bottom: 30px;
        }
        .profile-img {
            display: inline-block;
            margin: 14px 0 18px 0;
            border-radius: 50%;
            background: #f2f7ff;
            border: 2.5px solid #c3dafc;
            padding: 6px;
            height: 76px;
            width: 76px;
            object-fit: cover;
            box-shadow: 0 2px 8px #89b1e866;
        }
        form input[type="file"] {
            margin: 18px 0 20px 0;
            font-size: 1.05em;
            border: none;
            padding: 2px;
            width: 90%;
        }
        button {
            background: #0c3b6c;
            color: #fff;
            font-weight: 700;
            font-size: 1.1em;
            border: none;
            padding: 12px 0;
            border-radius: 7px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #3461a8;
        }
        .success-msg {
            margin: 10px 0 18px 0;
            color: #268b01;
            font-weight: 600;
            font-size: 1.04em;
        }
        .note {
            font-size: 0.95em;
            margin-top: 18px;
            color: #777;
            opacity: .87;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Profile Picture</h2>
    <div class="desc">Upload your display photo! The allowed files for this demo are not restricted. <br> After uploading, you can <b>refresh</b> to see your new image.</div>
    <?php
    if(isset($msg)) {
        echo "<div class='success-msg'>$msg</div>";
        $src = "uploads/" . htmlspecialchars($_FILES['file']['name']);
        // Show uploaded image preview if file is an image (for demo only)
        $ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif','bmp','webp'])) {
            echo "<img src='$src' class='profile-img' alt='Profile Picture'>";
        }
    }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required />
        <button type="submit">Upload Picture</button>
    </form>
    <div class="note">
        <b>Note:</b> This page is intentionally <span style="color:#c23c25;">insecure</span> and allows any file type. In real applications, always restrict and validate uploads.
    </div>
</div>
</body>
</html>
