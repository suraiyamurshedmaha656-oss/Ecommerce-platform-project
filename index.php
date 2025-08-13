<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My E-Commerce Platform</title>
  <style>
    body {
      background-color: lightblue;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
    }
    header {
      height: 300px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background-image: url('https://img.freepik.com/free-photo/cyber-monday-shopping-sales_23-2149247585.jpg?w=826&t=st=1689132446~exp=1689133046~hmac=bc69b5f57e8e5bc2e7bc2ea47db54d4b6ae7e774f85a6812de4b3a18d217b6c2');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    header h1 {
      background-color: rgba(0,0,0,0.5);
      padding: 20px;
      border-radius: 10px;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    ul li {
      display: inline;
      margin: 0 15px;
    }
    ul li a {
      text-decoration: none;
      color: #000;
      font-weight: bold;
    }
    footer {
      margin-top: 30px;
      padding: 10px;
      background-color: rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <header>
    <h1><?php echo "Welcome to My E-Commerce Site"; ?></h1>
  </header>

  <ul>
<li><a href="user/register.php">Register</a></li>
<li><a href="user/login.php">Login</a></li>
<li><a href="product/add_product.php">Add Product</a></li>
<li><a href="category/add_category.php">Add Category</a></li>
<li><a href="order/cart.php">Cart</a></li>
<li><a href="payment/simulate_payment.php">Simulate Payment</a></li>
<li><a href="review/add_review.php">Add Review</a></li>

  </ul>

  <h2>Shop the Latest Trends</h2>
  <p>Find amazing products at unbeatable prices!</p>

  <footer>
    <p>© 2025 My E-Commerce Platform. All rights reserved.</p>
  </footer>

</body>
</html>
