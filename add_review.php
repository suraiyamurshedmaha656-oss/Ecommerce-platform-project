<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["user_id"])) {
    echo "You must <a href='../user/login.php'>log in</a> to post a review.";
    exit;
}

// Fetch all products
$product_result = $conn->query("SELECT product_id, name FROM products");

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $product_id = $_POST["product_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $user_id, $product_id, $rating, $comment);

    if ($stmt->execute()) {
        $message = "<div class='success-message'>✅ Review added successfully. <a href='view_reviews.php?product_id=$product_id'>View Reviews</a></div>";
    } else {
        $message = "<div class='error-message'>❌ Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label, select, textarea {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            font-weight: bold;
        }
        select, textarea {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
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
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Review</h2>
    <?= $message ?>

    <form method="post">
        <label for="product_id">Product:</label>
        <select name="product_id" id="product_id" required>
            <option value="">Select</option>
            <?php while ($row = $product_result->fetch_assoc()) { ?>
                <option value="<?= htmlspecialchars($row['product_id']) ?>"><?= htmlspecialchars($row['name']) ?></option>
            <?php } ?>
        </select>

        <label for="rating">Rating:</label>
        <select name="rating" id="rating" required>
            <option value="">Rate</option>
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Fair</option>
            <option value="1">1 - Poor</option>
        </select>

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="4" required></textarea>

        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>
