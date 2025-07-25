<?php
// Database connection - intentionally vulnerable credentials in plain text
$conn = mysqli_connect("localhost", "root", "your_sql_password", "university_site")
    or die("DB Connection Failed!");
?>
