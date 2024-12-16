<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM purchases WHERE user_id = $user_id");
?>
<h1>Your Purchased Books</h1>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['author']; ?></td>
        <td><?php echo $row['price']; ?></td>
    </tr>
    <?php } ?>
</table>
<a href="customer_dashboard.php">Back to Dashboard</a>