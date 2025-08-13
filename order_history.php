<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["user_id"])) {
    echo "You must <a href='../user/login.php'>log in</a> to view your order history.";
    exit;
}

$user_id = $_SESSION["user_id"];

$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>

<h2>Your Order History</h2>

<?php while ($order = $orders->fetch_assoc()) { ?>
    <h4>Order #<?= $order["order_id"] ?> | <?= $order["order_date"] ?> | Status: <?= $order["status"] ?></h4>
    <ul>
        <?php
        $items = $conn->query("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.product_id WHERE order_id = {$order['order_id']}");
        while ($item = $items->fetch_assoc()) {
            echo "<li>{$item['name']} - Quantity: {$item['quantity']}</li>";
        }
        ?>
    </ul>
<?php } ?>
