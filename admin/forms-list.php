<?php
require "../config/db.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
<h2>All Forms</h2>

<a href="create-form.php">➕ Create New Form</a>
<hr>

<?php
$result = $conn->query("SELECT * FROM forms ORDER BY created_at DESC");

while ($row = $result->fetch_assoc()) {
    echo "
    <p>
      <strong>{$row['title']}</strong><br>
      <a href='../public/form.php?id={$row['id']}' target='_blank'>Public Link</a> |
      <a href='edit-form.php?id={$row['id']}'>Edit</a> |
      <a href='submissions.php?id={$row['id']}'>Submissions</a> |
      <a href='analytics.php?id={$row['id']}'>Analytics</a>
    </p>
    <hr>
    ";
}
?>
</div>
</body>
</html>
