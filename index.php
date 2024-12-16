<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'customer_dashboard.php'));
    exit();
}
?>
<h1>Welcome to the Online Bookstore</h1>
<a href="login.php">Login</a> | <a href="register.php">Register</a>