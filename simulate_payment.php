<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION["user_id"])) {
    echo "You must <a href='../user/login.php'>log in</a> to view your payments.";
    exit;
}

$user_id = $_SESSION["user_id"];

// Join orders and payments
$sql = "SELECT p.payment_id, p.amount, p.payment_date, o.order_id
        FROM payments p
        JOIN orders o ON p.order_id = o.order_id
        WHERE o.user_id = $user_id
        ORDER BY p.payment_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Payment History</title>
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        p {
            text-align: center;
            font-size: 16px;
            color: #555;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Payment History</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Payment ID</th>
                <th>Order ID</th>
                <th>Amount Paid</th>
                <th>Payment Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['payment_id']) ?></td>
                <td><?= htmlspecialchars($row['order_id']) ?></td>
                <td>$<?= number_format($row['amount'], 2) ?></td>
                <td><?= htmlspecialchars($row['payment_date']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No payments found.</p>
    <?php endif; ?>
</div>

</body>
</html>
