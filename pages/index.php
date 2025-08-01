<?php
include '../config/db.php';

// Get category filter (if selected)
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : '';

// Fetch categories for dropdown
$category_query = "SELECT * FROM categories";
$category_result = $conn->query($category_query);

// Fetch articles based on category selection - Main Gallery
$query = "
    SELECT articles.id, articles.title, articles.image, articles.created_at, 
           categories.name AS category_name, users.username AS author_name
    FROM articles
    LEFT JOIN categories ON articles.category_id = categories.id
    LEFT JOIN users ON articles.author_id = users.id
";

if (!empty($category_filter)) {
    $query .= " WHERE articles.category_id = " . intval($category_filter);
}

$query .= " ORDER BY articles.created_at DESC";

$result = $conn->query($query);

// Fetch another set of articles for the sidebar (Recent/Related) - Adjust Query as needed
$sidebar_query = "
    SELECT articles.id, articles.title
    FROM articles
    ORDER BY articles.created_at DESC
    LIMIT 5"; // Limit to 5 articles
$sidebar_result = $conn->query($sidebar_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Portal</title>
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

        /* Header Styling (Navbar) */
        .navbar {
            background-color: #fff !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: #007bff !important;
            letter-spacing: 0.05rem;
        }

        .navbar-nav .nav-link {
            color: #495057;
            margin-left: 1rem;
            transition: color 0.2s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        /* Main Content */
        .container.mt-4 {
            flex: 1;
            max-width: 1200px; /* Adjust as needed */
        }

        /* Category Filter */
        .form-select {
            width: auto;
            display: inline-block;
        }

        /* Image Gallery Styling */
        .image-gallery .col-md-3 { /* Four items per row */
            margin-bottom: 1.5rem;
        }

        .image-gallery .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 2.5em; /* Adjust height to match 2 lines */
        }

        .image-gallery .card:hover {
            transform: translateY(-0.25rem);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .image-gallery .card-img-top {
            height: 200px; /* Adjust height as needed */
            object-fit: cover; /* Maintain aspect ratio */
        }

        .image-gallery .card-body {
            padding: 1rem;
        }

        .image-gallery .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .sidebar h4 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 0.75rem;
        }

        .sidebar a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .sidebar a:hover {
            color: #0056b3;
        }

        /* Footer Styling */
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 2rem;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-newspaper"></i> News Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">
                            <i class="fas fa-info-circle"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">
                            <i class="fas fa-envelope"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/index.php">
                            <i class="fas fa-sign-out-alt"></i> Dashboard
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

    <div class="container mt-4">
        <!-- Category Filter -->
        <form method="GET" class="mb-3">
            <label for="category" class="fw-bold">Filter by Category:</label>
            <select name="category" id="category" class="form-select w-auto d-inline" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php while ($cat = $category_result->fetch_assoc()) { ?>
                    <option value="<?= intval($cat['id']) ?>" <?= intval($cat['id']) === $category_filter ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <div class="row">
            <!-- Image Gallery (Main Content) -->
            <div class="col-md-9 image-gallery">
                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <div class="col-md-3">
                                <div class="card">
                                    <?php if (!empty($row['image'])) { ?>
                                        <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="card-img-top">
                                    <?php } ?>
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="view_article.php?id=<?= intval($row['id']) ?>" class="text-decoration-none text-dark">
                                                <?= htmlspecialchars($row['title']) ?>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else {
                        echo "<p class='text-danger'>No articles found.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Sidebar (Article Links) -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h4>More Articles</h4>
                    <ul>
                        <?php
                        if ($sidebar_result->num_rows > 0) {
                            while ($side_row = $sidebar_result->fetch_assoc()) { ?>
                                <li>
                                    <a href="view_article.php?id=<?= intval($side_row['id']) ?>">
                                        <?= htmlspecialchars($side_row['title']) ?>
                                    </a>
                                </li>
                            <?php }
                        } else {
                            echo "<p class='text-muted'>No related articles.</p>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            © <?= date("Y") ?> News Portal |
            <a href="#" class="text-white">Terms of Service</a> |
            <a href="#" class="text-white">Privacy Policy</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>