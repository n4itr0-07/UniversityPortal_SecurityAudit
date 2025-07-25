<?php
include('config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Faculty Directory - Mint University</title>
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
    <h2>Faculty Directory</h2>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search faculty by name..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" />
        <button type="submit">Search</button>
    </form>

    <?php
    // Vulnerable reflected XSS via search parameter
    $query = "SELECT * FROM faculty";
    if(isset($_GET['search']) && $_GET['search'] !== '') {
        // UNSAFE direct string interpolation (vulnerable to SQLi)
        $search = $_GET['search'];
        $query .= " WHERE name LIKE '%$search%'";
        echo "<p>Searching for: " . $_GET['search'] . "</p>"; // Reflected XSS here
    }

    // Sample data (since no DB table faculty exists, using hardcoded array for demo)
    $facultyList = [
        ['id'=>1, 'name'=>'Dr. Alice Johnson', 'department'=>'Computer Science'],
        ['id'=>2, 'name'=>'Prof. Bob Williams', 'department'=>'Mathematics'],
        ['id'=>3, 'name'=>'Dr. Clara Smith', 'department'=>'Physics'],
        ['id'=>4, 'name'=>'Prof. David Lee', 'department'=>'Chemistry'],
        ['id'=>5, 'name'=>'Dr. Evelyn Clark', 'department'=>'Biology']
    ];

    // Filter faculty based on search (naive demo filtering)
    if(isset($_GET['search']) && $_GET['search'] !== '') {
        $filter = strtolower($_GET['search']);
        $filtered = [];
        foreach($facultyList as $fac) {
            if(strpos(strtolower($fac['name']), $filter) !== false) $filtered[] = $fac;
        }
    } else {
        $filtered = $facultyList;
    }
    ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th>Department</th></tr>
        </thead>
        <tbody>
        <?php
        foreach($filtered as $faculty) {
            echo "<tr><td>{$faculty['id']}</td><td>{$faculty['name']}</td><td>{$faculty['department']}</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
