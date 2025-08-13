<?php
include("../config/db.php");

// Fetch categories for dropdown
$category_sql = "SELECT * FROM categories";
$category_result = $conn->query($category_sql);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];

    $sql = "INSERT INTO products (name, description, price, category_id)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $name, $desc, $price, $category_id);

    if ($stmt->execute()) {
        $message = "<div class='success-message'>✅ Product added successfully. <a href='view_products.php'>View Products</a></div>";
    } else {
        $message = "<div class='error-message'>❌ Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* Header Navigation */
        .navbar {
            background-color: #333;
            overflow: hidden;
            padding: 10px 20px;
        }
        .navbar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
        }
        .navbar a:hover {
            background-color: #4CAF50;
            color: white;
        }

        /* Container */
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 15px;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

        .success-message, .error-message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="../index.php">🏠 Home</a>
    <a href="../user/register.php">Register</a>
    <a href="../user/login.php">Login</a>
    <a href="../product/view_products.php">View Products</a>
    <a href="../category/add_category.php">Add Category</a>
    <a href="../order/cart.php">Cart</a>
    <a href="../review/add_review.php">Review</a>
</div>

<!-- Main Content -->
<div class="container">
    <h2>Add Product</h2>
    <?= $message ?>

    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>

        <label>Category:</label>
        <select name="category_id" required>
            <option value="">Select</option>
            <?php while ($row = $category_result->fetch_assoc()) { ?>
                <option value="<?= $row['category_id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>

        <button type="submit">Add Product</button>
    </form>
</div>

</body>
</html>
