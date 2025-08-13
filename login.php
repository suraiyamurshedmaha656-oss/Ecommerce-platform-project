<?php
include("../config/db.php");
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: profile.php");
        exit();
    } else {
        $message = "<p style='color: red; text-align: center;'>Invalid email or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>
<style>
  /* Background and basic page styles */
  html, body {
    height: 100%;
    margin: 0;
    background-color: #e6d7f7; /* soft light purple */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  body {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  form {
    background-color: #ede7f6; /* soft lavender */
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    width: 350px;
    box-sizing: border-box;
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-weight: 600;
  }
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1.8px solid #b3b3cc;
    border-radius: 6px;
    font-size: 15px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
  }
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #7e57c2;
    outline: none;
  }
  button {
    width: 100%;
    padding: 12px 0;
    background-color: #7e57c2;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 17px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 3px 7px rgba(126, 87, 194, 0.5);
    transition: background-color 0.3s ease;
  }
  button:hover {
    background-color: #673ab7;
  }
  p {
    font-size: 16px;
    margin-top: 0;
    margin-bottom: 15px;
  }
</style>
</head>
<body>

<form method="post" action="">
    <h2>Login</h2>
    <?php echo $message; ?>
    <label for="email">Email:</label>
    <input id="email" type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input id="password" type="password" name="password" required>
    
    <button type="submit">Login</button>
</form>

</body>
</html>
