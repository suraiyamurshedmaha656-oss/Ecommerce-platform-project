<?php
include("../config/db.php");

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<h2>Category List</h2>
<a href="add_category.php">Add New Category</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row["category_id"] ?></td>
        <td><?= $row["name"] ?></td>
    </tr>
    <?php } ?>
</table>
