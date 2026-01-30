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

$form = $conn->query("SELECT structure_json FROM forms WHERE id=$form_id")->fetch_assoc();
$fields = json_decode($form['structure_json'], true);

$subs = $conn->query("SELECT response_json FROM form_submissions WHERE form_id=$form_id");

$counts = [];

foreach ($fields as $i => $field) {
    if (in_array($field['type'], ['dropdown', 'checkbox'])) {
        $options = explode(",", $field['options']);
        foreach ($options as $opt) {
            $counts[$i][trim($opt)] = 0;
        }
    }
}

while ($row = $subs->fetch_assoc()) {
    $responses = json_decode($row['response_json'], true);
    foreach ($responses as $i => $value) {
        if (is_array($value)) {
            foreach ($value as $v) $counts[$i][$v]++;
        } else {
            $counts[$i][$value]++;
        }
    }
}
?>

<h2>Analytics</h2>

<?php foreach ($counts as $index => $data): ?>
<h4><?= $fields[$index]['label'] ?></h4>
<ul>
<?php
$max = max($data);
$top = array_search($max, $data);
foreach ($data as $opt => $count):
?>
<li><?= $opt ?> – <?= $count ?></li>
<?php endforeach; ?>
</ul>
<b>Most selected:</b> <?= $top ?>
<?php endforeach; ?>
