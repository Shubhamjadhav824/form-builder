<?php
require "../config/db.php";

if (!isset($_GET['id'])) {
    die("Form ID missing");
}

$form_id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT title, description, structure_json FROM forms WHERE id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Form not found");
}

$form = $result->fetch_assoc();
$fields = json_decode($form['structure_json'], true);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<h2><?= htmlspecialchars($form['title']) ?></h2>
<p><?= htmlspecialchars($form['description']) ?></p>

<form method="POST" action="submit.php">
<input type="hidden" name="form_id" value="<?= $form_id ?>">

<?php foreach ($fields as $field): ?>
  <label><?= htmlspecialchars($field['label']) ?></label>

  <?php if ($field['type'] === 'text'): ?>
    <input
      type="text"
      name="<?= htmlspecialchars($field['label']) ?>"
      <?= !empty($field['required']) ? 'required' : '' ?>>
  <?php endif; ?>

  <?php if ($field['type'] === 'number'): ?>
    <input
      type="number"
      name="<?= htmlspecialchars($field['label']) ?>"
      <?= !empty($field['required']) ? 'required' : '' ?>>
  <?php endif; ?>

  <?php if ($field['type'] === 'dropdown'): ?>
    <select
      name="<?= htmlspecialchars($field['label']) ?>"
      <?= !empty($field['required']) ? 'required' : '' ?>>
      <option value="">-- Select --</option>
      <?php foreach ($field['options'] ?? [] as $opt): ?>
        <option value="<?= htmlspecialchars($opt) ?>">
          <?= htmlspecialchars($opt) ?>
        </option>
      <?php endforeach; ?>
    </select>
  <?php endif; ?>

  <?php if ($field['type'] === 'checkbox'): ?>
    <?php foreach ($field['options'] ?? [] as $opt): ?>
      <label>
        <input
          type="checkbox"
          name="<?= htmlspecialchars($field['label']) ?>[]"
          value="<?= htmlspecialchars($opt) ?>">
        <?= htmlspecialchars($opt) ?>
      </label><br>
    <?php endforeach; ?>
  <?php endif; ?>

<?php endforeach; ?>

<button type="submit">Submit</button>
</form>
</div>

</body>
</html>
