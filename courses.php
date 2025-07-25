<?php
include('config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Courses - Mint University</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { font-family: Arial, sans-serif; background: #f3f6fb; }
        .container {
            max-width: 720px; margin: 40px auto; background: #fff;
            border-radius: 12px; padding: 28px 28px; box-shadow: 0 2px 16px rgba(0,0,0,0.1);
        }
        h2 {
            color: #0c3b6c; font-weight: 700; margin-bottom: 20px;
        }
        form input[type=text] {
            width: 60%; padding: 9px 14px; font-size: 1.05em; border-radius: 6px; border: 1.8px solid #0c3b6caa;
            outline: none; transition: border-color 0.3s ease;
        }
        form input[type=text]:focus {
            border-color: #467ee8;
        }
        form button {
            padding: 10px 22px; background: #0c3b6c; border: none;
            border-radius: 6px; color: white; font-weight: 600;
            font-size: 1em; cursor: pointer;
            margin-left: 8px; transition: background 0.3s ease;
        }
        form button:hover {
            background: #3461a8;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        th, td {
            padding: 12px 14px; border: 1.5px solid #0c3b6c50; text-align: left; font-size: 1em;
        }
        th {
            background: #0c3b6c; color: white;
        }
        tr:nth-child(even) {
            background: #f8faff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Courses Offered</h2>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search courses by title..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" />
        <button type="submit">Search</button>
    </form>

    <?php
    // Vulnerable to SQLi + reflected XSS in output below
    $courses = [
        ['code' => 'CS101', 'title' => 'Introduction to Computer Science'],
        ['code' => 'MAT201', 'title' => 'Advanced Calculus'],
        ['code' => 'PHY301', 'title' => 'Quantum Mechanics'],
        ['code' => 'CHEM101', 'title' => 'Organic Chemistry'],
        ['code' => 'BIO105', 'title' => 'General Biology']
    ];

    if(isset($_GET['search']) && $_GET['search'] !== '') {
        $search = $_GET['search'];  // vulnerable raw input

        echo "<p>Showing results for: " . $_GET['search'] . "</p>"; // Reflected XSS!

        $matches = [];
        foreach($courses as $course) {
            if(stripos($course['title'], $search) !== false) {
                $matches[] = $course;
            }
        }
    } else {
        $matches = $courses;
    }
    ?>

    <table>
        <thead>
            <tr><th>Course Code</th><th>Course Title</th></tr>
        </thead>
        <tbody>
        <?php
        foreach ($matches as $course) {
            echo "<tr><td>{$course['code']}</td><td>{$course['title']}</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
