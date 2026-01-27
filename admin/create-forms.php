<?php
require "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $structure = $_POST['structure'];

    $stmt = $conn->prepare(
        "INSERT INTO forms (title, description, structure_json) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $title, $description, $structure);
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
<h2>Create Form</h2>

<form method="POST">
  <input type="text" name="title" placeholder="Form Title" required>
  <textarea name="description" placeholder="Description"></textarea>

  <h3>Fields</h3>
  <div id="fields"></div>

  <input type="hidden" name="structure" id="structure">

  <button type="button" onclick="addField()">Add Field</button>
  <button type="submit">Save Form</button>
</form>
</div>

<script src="../assets/js/form-builder.js"></script>
</body>
</html>
