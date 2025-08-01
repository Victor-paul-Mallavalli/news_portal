<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #222;
            color: white;
            padding: 15px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        .sidebar h3 {
            text-align: center;
            border-bottom: 2px solid white;
            padding-bottom: 10px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px;
            border-bottom: 1px solid gray;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li a:hover {
            background-color: gray;
            padding-left: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>News Portal</h3>
    <ul>
        <li><a href="/index.php">🏠 Home</a></li>
        <li><a href="/pages/latest.php">🆕 Latest Articles</a></li>
        <li><a href="/pages/categories.php">📂 Categories</a></li>

        <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="/auth/logout.php">🚪 Logout</a></li>
            <?php if ($_SESSION["role"] === "admin"): ?>
                <li><a href="/admin/index.php">⚙️ Admin Panel</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="/auth/login.php">🔑 Login</a></li>
            <li><a href="/auth/register.php">📝 Register</a></li>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>
