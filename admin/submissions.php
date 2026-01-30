<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../configuration/db.php";

$form_id = $_GET['form_id'] ?? 0;

/* Prepared statement (IMPORTANT) */
$stmt = $conn->prepare(
    "SELECT response_json, submitted_at FROM form_submissions WHERE form_id = ?"
);
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Submissions</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Submissions</h2>

<?php if ($result->num_rows === 0): ?>
    <p>No submissions yet.</p>
<?php endif; ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <div style="background:#fff; padding:15px; margin-bottom:10px; border-radius:5px;">
        <small><b>Submitted at:</b> <?= $row['submitted_at'] ?></small>
        <pre>
<?= json_encode(json_decode($row['response_json'], true), JSON_PRETTY_PRINT) ?>
        </pre>
    </div>
<?php endwhile; ?>

</body>
</html>
