<?php
include('config.php');
$results = null;
if(isset($_GET['search'])) {
    // Reflected XSS + SQL Injection vulnerabilities
    $search = $_GET['search'];
    $sql = "SELECT * FROM news WHERE title LIKE '%$search%'";
    $results = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>University News - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 780px;
            margin: 40px auto 70px auto;
            padding: 30px 28px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 22px rgba(0,0,0,0.1);
        }
        h2 {
            color: #0c3b6c;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        form input[type=text] {
            width: 70%;
            padding: 10px 14px;
            font-size: 1.1em;
            border-radius: 7px 0 0 7px;
            border: 1.8px solid #0c3b6caa;
            border-right: none;
            outline: none;
            transition: border-color 0.3s ease;
        }
        form input[type=text]:focus {
            border-color: #467ee8;
        }
        form button {
            background: #0c3b6c;
            padding: 11.5px 22px;
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.1em;
            border-radius: 0 7px 7px 0;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #3461a8;
        }
        .search-info {
            margin-top: 16px;
            font-weight: 600;
            color: #1f497d;
            opacity: 0.9;
            text-align: center;
        }
        .news-item {
            padding: 18px 20px;
            border-bottom: 1px solid #ddd;
            color: #222;
        }
        .news-item b {
            color: #0c3b6c;
            font-size: 1.3em;
        }
        .news-item:last-child {
            border: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>University News Board</h2>
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search news titles..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" />
        <button type="submit">Search</button>
    </form>

    <?php
    if(isset($_GET['search'])) {
        // Reflected XSS in output left intentionally
        echo "<div class='search-info'>Results for <b>" . $_GET['search'] . "</b>:</div>";
        if($results && mysqli_num_rows($results) > 0) {
            while($row = mysqli_fetch_assoc($results)) {
                echo "<div class='news-item'><b>" . $row['title'] . "</b><br>" . $row['content'] . "</div>";
            }
        } else {
            echo "<div class='search-info'>No results found.</div>";
        }
    } else {
        // Show all news by default
        echo "<div class='search-info'>Latest News:</div>";
        $res = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC LIMIT 5");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<div class='news-item'><b>" . $row['title'] . "</b><br>" . $row['content'] . "</div>";
        }
    }
    ?>
</div>

</body>
</html>
