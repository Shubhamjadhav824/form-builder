<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../configuration/db.php";

$result = $conn->query("SELECT * FROM forms ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forms List</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function copyLink(id) {
            const link = `${window.location.origin}/public/form.php?id=${id}`;
            navigator.clipboard.writeText(link);
            alert("Form link copied!");
        }
    </script>
</head>
<body>

<form method="POST" action="logout.php" style="text-align:right;">
    <button style="background:#dc3545;">Logout</button>
</form>

<h2>Forms List</h2>

<table border="1" cellpadding="10" style="background:#fff;">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td>
        <a href="../public/form.php?id=<?= $row['id'] ?>">Open</a> |
        <a href="submissions.php?form_id=<?= $row['id'] ?>">Submissions</a> |
        <button onclick="copyLink(<?= $row['id'] ?>)">Copy Link</button>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
