<?php
include("../config/db.php");

if (!isset($_GET["product_id"])) {
    echo "Product ID not provided.";
    exit;
}

$product_id = $_GET["product_id"];

// Get product info
$product = $conn->query("SELECT name FROM products WHERE product_id = $product_id")->fetch_assoc();

// Get all reviews
$reviews = $conn->query("SELECT r.rating, r.comment, u.name
                         FROM reviews r
                         JOIN users u ON r.user_id = u.user_id
                         WHERE r.product_id = $product_id");
?>

<h2>Reviews for: <?= $product["name"] ?></h2>

<?php if ($reviews->num_rows > 0): ?>
    <ul>
        <?php while ($row = $reviews->fetch_assoc()) { ?>
            <li>
                <strong><?= $row["name"] ?>:</strong>
                <?= str_repeat("⭐", $row["rating"]) ?><br>
                <?= htmlspecialchars($row["comment"]) ?>
            </li><br>
        <?php } ?>
    </ul>
<?php else: ?>
    <p>No reviews for this product yet.</p>
<?php endif; ?>
