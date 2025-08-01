<?php
session_start();
include '../config/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    echo "❌ Access denied! Only admins can access this page.";
    exit();
}

$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_articles = $conn->query("SELECT COUNT(*) AS count FROM articles")->fetch_assoc()['count'];
$total_categories = $conn->query("SELECT COUNT(*) AS count FROM categories")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .navbar {
            background-color: #343a40;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 2600px;
            padding: 20px;
        }
        .card {
            background-color: white;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .card h4 {
            margin-bottom: 10px;
        }
        .bg-primary { background-color: #007bff !important; color: white; }
        .bg-success { background-color: #28a745 !important; color: white; }
        .bg-warning { background-color: #ffc107 !important; color: black; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Admin Panel</h2>
        <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
    </div>
    
    <div class="sidebar">
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="manage_articles.php">📝 Manage Articles</a>
        <a href="manage_categories.php">📂 Manage Categories</a>
        <a href="manage_users.php">👥 Manage Users</a>
        <a href="../auth/logout.php" style="color: red;">🚪 Logout</a>
    </div>
    
    <div class="main-content">
        <h2>Admin Dashboard</h2>
        <div class="card bg-primary">
            <h4>Total Users</h4>
            <p class="display-6"><?php echo $total_users; ?></p>
        </div>
        <div class="card bg-success">
            <h4>Total Articles</h4>
            <p class="display-6"><?php echo $total_articles; ?></p>
        </div>
        <div class="card bg-warning">
            <h4>Total Categories</h4>
            <p class="display-6"><?php echo $total_categories; ?></p>
        </div>
    </div>
</body>
</html>
