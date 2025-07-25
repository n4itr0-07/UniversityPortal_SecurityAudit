<?php
include('config.php');
// No authorization or authentication (intentionally vulnerable)
if(isset($_GET['delete_user_id'])) {
    $user_id = $_GET['delete_user_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Mint University Portal</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body { background: #f3f6fb; font-family: Arial, sans-serif; }
        .container {
            max-width: 800px;
            margin: 40px auto 60px auto;
            padding: 30px 28px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0c3b6c;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 16px;
            border: 1.5px solid #0c3b6c66;
            text-align: left;
            font-size: 1em;
        }
        th {
            background: #0c3b6c;
            color: white;
        }
        tr:nth-child(even) {
            background: #f8faff;
        }
        a.delete-link {
            background: #d13438;
            color: white;
            padding: 7px 14px;
            border-radius: 7px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease;
            display: inline-block;
        }
        a.delete-link:hover {
            background: #a42223;
        }
        .note {
            font-size: 0.9em;
            color: #444;
            font-style: italic;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Panel - Manage Users</h2>
    <table>
        <thead>
            <tr><th>ID</th><th>Username</th><th>Action</th></tr>
        </thead>
        <tbody>
            <?php
            $res = mysqli_query($conn, "SELECT * FROM users");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td>
                <td><a class='delete-link' href='admin.php?delete_user_id={$row['id']}' onclick=\"return confirm('Are you sure you want to delete user {$row['username']}?');\">Delete</a></td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="note">
        * This panel is intentionally unsecured for demonstration purposes. Anyone can perform deletions.<br>
        Always implement authentication and authorization in real applications.
    </div>
</div>

</body>
</html>
