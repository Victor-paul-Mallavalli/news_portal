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
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom Admin Styles -->
    <style>
        /* General Page Styling */
        /* CSS Reset (Place at the very top of your <style> block) */
        *, *::before, *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

        body {
            line-height: 1.5; /* Improve text readability */
            -webkit-font-smoothing: antialiased; /* Better font rendering on macOS */
        }

        img, picture, video, canvas, svg {
            display: block;
            max-width: 100%;
        }

        input, button, textarea, select {
            font: inherit;
        }

        p, h1, h2, h3, h4, h5, h6 {
            overflow-wrap: break-word;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40; /* Darker text for better readability */
        }

        /* Navbar */
        .navbar {
            background-color: #343a40 !important; /* Dark background for contrast */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar-text {
            color: rgba(255, 255, 255, 0.8) !important; /* Lighter text for the welcome message */
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0; /* Stick to the top */
            left: 0;
            width: 250px; /* Adjusted width */
            padding-top: 20px;
            background-color: #fff; /* Light background for the sidebar */
            border-right: 1px solid #dee2e6; /* Add a subtle border */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05); /* Lighter shadow */
        }

        .sidebar .nav-link {
            color: #495057; /* Darker color for sidebar links */
            padding: 12px 20px; /* Adjust padding */
            transition: all 0.3s;
            font-weight: 500; /* Slightly bolder font */
        }

        .sidebar .nav-link i {
            margin-right: 8px; /* Add space for icons */
            opacity: 0.7; /* Tone down icons */
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            color: white;
            border-radius: 0; /* Remove rounded corners for a modern look */
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef; /* Light gray hover effect */
            color: #0056b3; /* Darker blue on hover */
        }

        .sidebar .nav-link.text-danger:hover {
            background-color: #f8d7da; /* Light red on hover for logout */
            color: #721c24; /* Darker red on hover for logout */
        }

        /* Main Content */
        .main-content {
            margin-left: 250px; /* Match sidebar width */
            padding: 20px;
        }

        /* Dashboard Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* More noticeable shadow */
            transition: transform 0.2s ease-in-out; /* Smooth transition */
        }

        .card:hover {
            transform: translateY(-5px); /* Slight lift on hover */
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #212529;
        }

        .display-6 {
            font-size: 2.5rem;
            font-weight: 500;
            color: #fff;
        }

        .bg-primary {
            background-color: #007bff !important; /* Bootstrap primary color */
        }

        .bg-success {
            background-color: #28a745 !important; /* Bootstrap success color */
        }

        .bg-warning {
            background-color: #ffc107 !important; /* Bootstrap warning color */
            color: #212529 !important; /* Adjust text color for contrast */
        }


        /* Heading */
        .main-content h2 {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .icon-text{
            display: flex;
        }
        .icon-text i{
            padding-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../pages/index.php">Admin Panel</a>
            <span class="navbar-text text-white">Welcome, <?php echo $_SESSION['username']; ?>!</span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i> <span class="icon-text"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_articles.php">
                                <i class="fas fa-file-alt"></i><span class="icon-text"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Manage Articles</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_categories.php">
                                <i class="fas fa-folder-open"></i> <span class="icon-text"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Manage Categories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_users.php">
                                <i class="fas fa-users"></i><span class="icon-text"> <i class="fa fa-users" aria-hidden="true"></i>Manage Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt"></i> <span class="icon-text"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <h2 class="mt-4">Admin Dashboard</h2>

                <div class="row">
                    <!-- Users Count -->
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="display-6"><?= $total_users ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Articles Count -->
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Articles</h5>
                                <p class="display-6"><?= $total_articles ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Count -->
                    <div class="col-md-4">
                        <div class="card bg-warning text-dark"> <!-- Text dark for contrast on yellow -->
                            <div class="card-body">
                                <h5 class="card-title">Total Categories</h5>
                                <p class="display-6"><?= $total_categories ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</body>
</html>