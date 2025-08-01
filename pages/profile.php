<?php
session_start();
include '../config/db.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle profile update
$success_msg = "";
$error_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate the username
    if (empty($username)) {
        $error_msg = "❌ Username cannot be empty.";
    }
	//Validate email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "❌ Invalid email format";
    }


    // Update user details
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $username, $email, $hashed_password, $user_id);
    } else {
        $update_query = "UPDATE users SET username=?, email=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $username, $email, $user_id);
    }

    if ($stmt->execute() && empty($error_msg)) {
        $success_msg = "✅ Profile updated successfully!";
        $_SESSION['username'] = $username; // Update session username
    } else {
        $error_msg = "❌ Failed to update profile.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - News Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #fff !important; /* Light background for the navbar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            color: #007bff !important; /* Brand color */
        }

        .navbar-nav .nav-link {
            color: #343a40;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #007bff;
        }

        .main-content {
            padding: 2rem;
        }

        .profile-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 2rem;
            text-align: center;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .profile-card:hover {
            transform: translateY(-0.25rem);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .profile-card img {
            width: 120px;
            border-radius: 50%;
            margin-bottom: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
        }

        .profile-card h2 {
            color: #007bff;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
            letter-spacing: 0.05rem;
        }

        .profile-card .text-muted {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            margin-bottom: 1.25rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: auto;
        }

        /* Message Styling */
        .alert {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar (Assuming it's the same as index.php) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-newspaper"></i> News Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <main class="main-content">
        <div class="container">
            <div class="profile-card">
                <img src="../assets/images/default-user.png" alt="Profile Picture" class="rounded-circle">
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>

                <!-- Success/Error Messages -->
                <?php if ($success_msg) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
                <?php if ($error_msg) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

                <!-- Update Profile Form -->
                <form method="POST" class="mt-4">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current password)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            © <?= date("Y") ?> News Portal
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>