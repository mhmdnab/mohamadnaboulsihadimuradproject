<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = intval($_POST['book_id']);

    
    $query = "SELECT * FROM books WHERE id = ? AND quantity > 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();

       
        $conn->begin_transaction();
        try {
            
            $update_stock = "UPDATE books SET quantity = quantity - 1 WHERE id = ?";
            $stmt = $conn->prepare($update_stock);
            $stmt->bind_param('i', $book_id);
            $stmt->execute();

            
            $insert_purchase = "INSERT INTO purchased_books (user_id, book_id, purchase_date) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($insert_purchase);
            $stmt->bind_param('ii', $user_id, $book_id);
            $stmt->execute();

            $conn->commit();
            echo "<p>Book purchased successfully!</p>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Failed to purchase book: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Book is out of stock or does not exist.</p>";
    }
}


$query = "SELECT * FROM books WHERE quantity > 0";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Books</title>
</head>
<body>
    <h1>Buy Books</h1>
    <a href="view_purchased_books.php">View Purchased Books</a> | <a href="logout.php">Logout</a>
    <hr>

    <h2>Available Books</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
        <?php while ($book = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td>$<?= htmlspecialchars($book['price']) ?></td>
                <td><?= htmlspecialchars($book['quantity']) ?></td>
                <td>
                    <form method="POST" action="">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                        <button type="submit">Buy</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
