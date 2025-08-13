<?php
include("../config/db.php");

$sql = "SELECT p.product_id, p.name, p.description, p.price, c.name AS category 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.category_id";

$result = $conn->query($sql);
?>

<h2>Product List</h2>
<a href="add_product.php">Add New Product</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["description"] ?></td>
        <td>$<?= $row["price"] ?></td>
        <td><?= $row["category"] ?></td>
        <td>
            <a href="edit_product.php?id=<?= $row['product_id'] ?>">Edit</a> |
            <a href="delete_product.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>
