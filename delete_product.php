<?php
include("../config/db.php");

$id = $_GET["id"];

$conn->query("DELETE FROM products WHERE product_id = $id");

header("Location: view_products.php");
exit;
