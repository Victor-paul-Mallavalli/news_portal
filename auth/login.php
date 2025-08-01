<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user data from the database
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            echo "✅ Login successful! Redirecting...";

            // Redirect based on role
            if ($role === 'admin') {
                header("refresh:2; url=../pages/index.php"); // Redirect admins
            } else {
                header("refresh:2; url=../pages/index.php"); // Redirect users
            }
            exit();
        } else {
            echo "❌ Incorrect password!";
        }
    } else {
        echo "❌ No account found with this email!";
    }

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
            <h2>Login</h2>
      
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
      
            <div class="remember-forgot">
              <label><input type="checkbox"> Remember me</label>
              <a href="#">Forgot Password?</a>
            </div>
      
            <button type="submit">Login</button>
      
            <div class="register-link">
              <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
          </form>
        </div>
      
      </div>
</body>
</html>
