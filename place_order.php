<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["user_id"])) {
    echo "You must <a href='../user/login.php'>log in</a> to place an order.";
    exit;
}

if (empty($_SESSION["cart"])) {
    echo "Cart is empty. <a href='cart.php'>Go back</a>";
    exit;
}

$user_id = $_SESSION["user_id"];
$conn->begin_transaction();

try {
    // Insert order
    $conn->query("INSERT INTO orders (user_id) VALUES ($user_id)");
    $order_id = $conn->insert_id;

    $total_amount = 0;

    // Insert each item
    foreach ($_SESSION["cart"] as $product_id => $qty) {
        $product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();
        $price = $product["price"];
        $subtotal = $price * $qty;
        $total_amount += $subtotal;

        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $order_id, $product_id, $qty);
        $stmt->execute();
    }

    // Simulated payment
    $stmt = $conn->prepare("INSERT INTO payments (order_id, amount) VALUES (?, ?)");
    $stmt->bind_param("id", $order_id, $total_amount);
    $stmt->execute();

    $conn->commit();
    unset($_SESSION["cart"]);

    echo "Order placed successfully! <a href='order_history.php'>View Order History</a>";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error placing order: " . $e->getMessage();
}
