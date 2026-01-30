<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>


<?php
require_once "../configuration/db.php";

$form_id = $_GET['form_id'];

$subs = $conn->query(
    "SELECT * FROM form_submissions WHERE form_id = $form_id"
);
?>

<h2>Submissions</h2>

<?php while ($row = $subs->fetch_assoc()): ?>
<pre>
<?= json_encode(json_decode($row['response_json']), JSON_PRETTY_PRINT) ?>
</pre>
<?php endwhile; ?>
