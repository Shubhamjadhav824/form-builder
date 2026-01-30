<?php
require_once "../configuration/db.php";

$form_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM forms WHERE id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$form = $stmt->get_result()->fetch_assoc();

$fields = json_decode($form['structure_json'], true);
?>

<h2><?= htmlspecialchars($form['title']) ?></h2>
<p><?= htmlspecialchars($form['description']) ?></p>

<form method="POST" action="submit.php">
    <input type="hidden" name="form_id" value="<?= $form_id ?>">

<?php foreach ($fields as $index => $field): ?>
    <label><?= htmlspecialchars($field['label']) ?></label><br>

    <?php if ($field['type'] === "text" || $field['type'] === "number"): ?>
        <input
            type="<?= $field['type'] ?>"
            name="response[<?= $index ?>]"
            <?= isset($field['required']) ? "required" : "" ?>
        >
    <?php else: ?>
        <?php
        $options = explode(",", $field['options']);
        foreach ($options as $opt):
        ?>
            <input
                type="<?= $field['type'] === 'dropdown' ? 'radio' : 'checkbox' ?>"
                name="response[<?= $index ?>][]"
                value="<?= trim($opt) ?>"
            >
            <?= trim($opt) ?><br>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>
<?php endforeach; ?>

    <button type="submit">Submit</button>
</form>

