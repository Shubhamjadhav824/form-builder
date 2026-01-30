<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once "../configuration/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $structure = json_encode($_POST['fields']);

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
    <title>Create Form</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<h2>Create New Form</h2>

<form method="POST">
    <label>Form Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea><br><br>

    <h3>Fields</h3>
    <div id="fields"></div>

    <button type="button" onclick="addField()">Add Field</button><br><br>
    <button type="submit">Save Form</button>
</form>

<script>
let fieldIndex = 0;

function addField() {
    const div = document.createElement("div");
    div.className = "field";

    div.innerHTML = `
        <label>Label</label>
        <input type="text" name="fields[${fieldIndex}][label]" required>

        <label>Type</label>
        <select name="fields[${fieldIndex}][type]" onchange="toggleOptions(this, ${fieldIndex})">
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="dropdown">Dropdown</option>
            <option value="checkbox">Checkbox</option>
        </select>

        <label>Required</label>
        <input type="checkbox" name="fields[${fieldIndex}][required]" value="1">

        <div id="options-${fieldIndex}" style="display:none">
            <label>Options (comma separated)</label>
            <input type="text" name="fields[${fieldIndex}][options]">
        </div>
    `;
    document.getElementById("fields").appendChild(div);
    fieldIndex++;
}

function toggleOptions(select, index) {
    const optionsDiv = document.getElementById(`options-${index}`);
    optionsDiv.style.display =
        (select.value === "dropdown" || select.value === "checkbox")
        ? "block" : "none";
}
</script>

</body>
</html>
