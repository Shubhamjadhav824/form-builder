<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../configuration/db.php";

$form_id = $_GET['form_id'] ?? 0;

/* Fetch form structure */
$formStmt = $conn->prepare(
    "SELECT structure_json FROM forms WHERE id = ?"
);
$formStmt->bind_param("i", $form_id);
$formStmt->execute();
$form = $formStmt->get_result()->fetch_assoc();
$fields = json_decode($form['structure_json'], true);

/* Fetch submissions */
$subStmt = $conn->prepare(
    "SELECT response_json FROM form_submissions WHERE form_id = ?"
);
$subStmt->bind_param("i", $form_id);
$subStmt->execute();
$subs = $subStmt->get_result();

$analytics = [];
$totalSubmissions = $subs->num_rows;

/* Initialize dropdown counters */
foreach ($fields as $field) {
    if ($field['type'] === 'dropdown') {
        foreach ($field['options'] as $opt) {
            $analytics[$field['label']][$opt] = 0;
        }
    }
}

/* Count responses */
while ($row = $subs->fetch_assoc()) {
    $response = json_decode($row['response_json'], true);

    foreach ($analytics as $label => $options) {
        if (isset($response[$label])) {
            $analytics[$label][$response[$label]]++;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Analytics</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Analytics</h2>
<p><b>Total Submissions:</b> <?= $totalSubmissions ?></p>

<?php foreach ($analytics as $label => $options): ?>
    <h3><?= htmlspecialchars($label) ?></h3>
    <ul>
        <?php
        arsort($options);
        $mostSelected = array_key_first($options);
        ?>
        <?php foreach ($options as $opt => $count): ?>
            <li><?= $opt ?> – <?= $count ?></li>
        <?php endforeach; ?>
    </ul>
    <p><b>Most selected:</b> <?= $mostSelected ?></p>
<?php endforeach; ?>

</body>
</html>
