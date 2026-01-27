<?php
require "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

$form_id = (int)$_POST['form_id'];
unset($_POST['form_id']);

$stmt = $conn->prepare("SELECT structure_json FROM forms WHERE id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Form not found");
}

$form = $result->fetch_assoc();
$fields = json_decode($form['structure_json'], true);

$errors = [];
$response = [];

foreach ($fields as $field) {
    $label = $field['label'];
    $value = $_POST[$label] ?? null;

    if (!empty($field['required']) && empty($value)) {
        $errors[] = "$label is required";
        continue;
    }

    if ($field['type'] === 'number' && !empty($value) && !is_numeric($value)) {
        $errors[] = "$label must be a number";
        continue;
    }

    if (is_array($value)) {
        $value = implode(", ", $value);
    }

    $response[$label] = htmlspecialchars($value);
}

if (!empty($errors)) {
    echo "<h3>Submission Error</h3>";
    echo implode("<br>", $errors);
    exit;
}

$response_json = json_encode($response);

$stmt = $conn->prepare(
    "INSERT INTO form_submissions (form_id, response_json) VALUES (?, ?)"
);
$stmt->bind_param("is", $form_id, $response_json);
$stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<h2>Thank You!</h2>
<p>Your response has been submitted successfully.</p>
</div>

</body>
</html>
