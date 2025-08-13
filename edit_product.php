<?php
include("../config/db.php");

$id = $_GET["id"];

$product = $conn->query("SELECT * FROM products WHERE product_id = $id")->fetch_assoc();
$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];

    $sql = "UPDATE products SET name=?, description=?, price=?, category_id=? WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $desc, $price, $category_id, $id);

    if ($stmt->execute()) {
        echo "Product updated successfully. <a href='view_products.php'>Back to List</a>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Edit Product</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>
    Description: <textarea name="description" required><?= $product['description'] ?></textarea><br><br>
    Price: <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required><br><br>
    Category:
    <select name="category_id" required>
        <?php while ($cat = $categories->fetch_assoc()) { ?>
            <option value="<?= $cat['category_id'] ?>" <?= ($cat['category_id'] == $product['category_id']) ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>
        <?php } ?>
    </select><br><br>
    <button type="submit">Update Product</button>
</form>
