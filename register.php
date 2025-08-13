<?php 
include("../config/db.php");

$message = ""; // To store feedback message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $message = "<p style='color: green; text-align:center;'>Registration successful. <a href='login.php'>Login here</a></p>";
    } else {
        $message = "<p style='color: red; text-align:center;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register</title>
<style>
  /* Soft pastel background colors */
  html, body {
    height: 100%;
    margin: 0;
    background-color: #cce7f0; /* soft pastel light blue */
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
  }
  h2 {
    margin-bottom: 25px;
    text-align: center;
    color: #333;
    font-weight: 600;
  }
  label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #555;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1.8px solid #b3b3cc;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 15px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #7e57c2; /* subtle purple highlight */
    outline: none;
  }
  button {
    width: 100%;
    padding: 12px 0;
    background-color: #7e57c2; /* medium purple */
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
    background-color: #673ab7; /* darker purple on hover */
  }
  p {
    font-size: 16px;
    margin-top: 0;
    margin-bottom: 15px;
  }
  a {
    color: #7e57c2;
    text-decoration: none;
  }
  a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<form method="post" action="">
    <h2>Register</h2>
    
    <?php echo $message; ?>
    
    <label for="name">Name:</label>
    <input id="name" type="text" name="name" required>
    
    <label for="email">Email:</label>
    <input id="email" type="email" name="email" required>
    
    <label for="password">Password:</label>
    <input id="password" type="password" name="password" required>
    
    <button type="submit">Register</button>
</form>

</body>
</html>
