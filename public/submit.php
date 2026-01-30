<?php
require_once "../configuration/db.php";

$form_id = $_POST['form_id'];
$response = json_encode($_POST['response']);

$stmt = $conn->prepare(
    "INSERT INTO form_submissions (form_id, response_json) VALUES (?, ?)"
);
$stmt->bind_param("is", $form_id, $response);
$stmt->execute();

echo "Form submitted successfully";
