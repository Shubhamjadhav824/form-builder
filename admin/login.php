<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>


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

<form method="POST">
    <h2>Admin Login</h2>
    <?= $error ?? "" ?><br>
    <input name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button>Login</button>
</form>
