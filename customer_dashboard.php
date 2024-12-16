<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Customer Dashboard</h1>
    <a href="buy_book.php">Buy Books</a> | 
    <a href="view_purchased_books.php">Purchased Books</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
