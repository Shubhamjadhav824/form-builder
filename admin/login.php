<?php
session_start();

if ($_POST) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin'] = true;
        header("Location: create-form.php");
        exit;
    }
    $error = "Invalid credentials";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<form method="POST">
    <h2>Admin Login</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <input name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

</body>
</html>
