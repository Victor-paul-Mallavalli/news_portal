<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "❌ Email already registered!";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'reader')");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "✅ Registration successful! <a href='../auth/login.php'>Login</a>";
        } else {
            echo "❌ Registration failed!";
        }
    }
    $check_email->close();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="../assets/css/style2.css">
<body>
    <div class="wrapper">

        <div class="login-box">
          <form method="POST">
            <h2>Register</h2>

            <div class="input-box">
              <span class="icon">
                <ion-icon name="mail"></ion-icon>
              </span>
              <input type="text" name="username" required>
              <label>Username</label>
            </div>
      
            <div class="input-box">
              <span class="icon">
                <ion-icon name="mail"></ion-icon>
              </span>
              <input type="email" name="email" required>
              <label>Email</label>
            </div>
      
            <div class="input-box">
              <span class="icon">
                <ion-icon name="lock-closed"></ion-icon>
              </span>
              <input type="password" name="password" required>
              <label>Password</label>
            </div>
      
            <!-- <div class="remember-forgot">
              <label><input type="checkbox"> Remember me</label>
              <a href="#">Forgot Password?</a>
            </div> -->
      
            <button type="submit">Register</button>
      
            <div class="register-link">
              <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
          </form>
        </div>
      
      </div>
</body>
</html>
