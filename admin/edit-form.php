<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>


<?php
require "../config/db.php";
$id = (int)$_GET['id'];

$form = $conn->query("SELECT * FROM forms WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare(
        "UPDATE forms SET title=?, description=?, structure_json=? WHERE id=?"
    );
    $stmt->bind_param(
        "sssi",
        $_POST['title'],
        $_POST['description'],
        $_POST['structure'],
        $id
    );
    $stmt->execute();

    header("Location: forms-list.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="container">
<h2>Edit Form</h2>

<form method="POST">
  <input type="text" name="title" value="<?= htmlspecialchars($form['title']) ?>" required>
  <textarea name="description"><?= htmlspecialchars($form['description']) ?></textarea>

  <div id="fields"></div>
  <input type="hidden" name="structure" id="structure">

  <button type="button" onclick="addField()">Add Field</button>
  <button type="submit">Update Form</button>
</form>
</div>

<script>
let fields = <?= $form['structure_json'] ?>;
</script>
<script src="../assets/js/form-builder.js"></script>
</body>
</html>
