<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<form method="POST" action="logout.php" style="text-align:right;">
    <button style="background:#dc3545;">Logout</button>
</form>

<h2>Admin Dashboard</h2>

<ul>
    <li><a href="create-form.php">➕ Create New Form</a></li>
    <li><a href="forms-list.php">📋 View All Forms</a></li>
</ul>

</body>
</html>
