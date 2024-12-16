<?php
include 'db.php';
session_start();
$result = $conn->query("SELECT * FROM books");
?>
<h1>Book List</h1>
<table border="1">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Quantity</th>
        <?php if ($_SESSION['role'] === 'admin') { ?>
            <th>Actions</th>
        <?php } ?>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['author']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <?php if ($_SESSION['role'] === 'admin') { ?>
            <td>
                <a href="edit_book.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_book.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>
<a href="<?php echo $_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'customer_dashboard.php'; ?>">Back to Dashboard</a>