<?php
require "../config/db.php";
$form_id = (int)$_GET['id'];

$subs = $conn->query(
    "SELECT response_json FROM form_submissions WHERE form_id=$form_id"
);

$stats = [];

while ($row = $subs->fetch_assoc()) {
    $data = json_decode($row['response_json'], true);

    foreach ($data as $field => $value) {
        $stats[$field][$value] = ($stats[$field][$value] ?? 0) + 1;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<h2>Form Analytics</h2>

<?php
if (!$stats) {
    echo "<p>No data available.</p>";
}

foreach ($stats as $field => $values) {
    arsort($values);
    echo "<h3>$field</h3>";

    foreach ($values as $option => $count) {
        echo "$option – $count<br>";
    }

    echo "<strong>Most Selected:</strong> " . array_key_first($values);
    echo "<hr>";
}
?>
</div>

</body>
</html>
