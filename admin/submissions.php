<?php
require "../config/db.php";
$form_id = (int)$_GET['id'];

$form = $conn->query("SELECT title FROM forms WHERE id=$form_id")->fetch_assoc();
$subs = $conn->query(
    "SELECT * FROM form_submissions WHERE form_id=$form_id ORDER BY submitted_at DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<h2>Submissions – <?= htmlspecialchars($form['title']) ?></h2>

<?php
if ($subs->num_rows === 0) {
    echo "<p>No submissions yet.</p>";
}

while ($row = $subs->fetch_assoc()) {
    $data = json_decode($row['response_json'], true);

    echo "<div><strong>ID:</strong> {$row['id']}<br>";
    echo "<strong>Date:</strong> {$row['submitted_at']}<br><br>";

    foreach ($data as $k => $v) {
        echo "<strong>$k:</strong> $v<br>";
    }

    echo "</div><hr>";
}
?>
</div>

</body>
</html>
