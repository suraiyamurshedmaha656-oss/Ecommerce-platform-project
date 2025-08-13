<?php
session_start();
include("../config/db.php");

// Add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    // Add to cart session
    $_SESSION["cart"][$product_id] = $quantity;
}

// Fetch all products for display
$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Products</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        select, input, button {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #28a745;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #f1f1f1;
            margin: 5px 0;
            padding: 8px;
            border-radius: 4px;
        }
        a {
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }
        a:hover {
            background: #0056b3;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Available Products</h2>

    <form method="post">
        <select name="product_id" required>
            <?php while ($row = $products->fetch_assoc()) { ?>
                <option value="<?= $row['product_id'] ?>"><?= $row['name'] ?> ($<?= $row['price'] ?>)</option>
            <?php } ?>
        </select>
        Quantity: 
        <input type="number" name="quantity" value="1" min="1" required>
        <button type="submit">Add to Cart</button>
    </form>

    <hr>

    <h2>Your Cart</h2>
    <?php
    if (!empty($_SESSION["cart"])) {
        $total = 0;
        echo "<ul>";
        foreach ($_SESSION["cart"] as $product_id => $qty) {
            $product = $conn->query("SELECT * FROM products WHERE product_id = $product_id")->fetch_assoc();
            $subtotal = $product["price"] * $qty;
            $total += $subtotal;
            echo "<li>{$product['name']} - Quantity: $qty - Subtotal: \${$subtotal}</li>";
        }
        echo "</ul>";
        echo "<p><strong>Total: \$$total</strong></p>";
        echo "<p><a href='place_order.php'>Place Order</a></p>";
    } else {
        echo "<p>Cart is empty.</p>";
    }
    ?>
</div>
</body>
</html>
