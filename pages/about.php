<?php
include '../config/db.php';  // Ensure this is still needed for your header/footer

// Get category filter (if selected) - Remove if header/footer don't need it
$category_filter = isset($_GET['category']) ? intval($_GET['category']) : '';

// Fetch categories for dropdown - Remove if header/footer don't need it
$category_query = "SELECT * FROM categories";
$category_result = $conn->query($category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - News Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom Styles - Only Unique Styles for About Page -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            max-width: 900px;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        h2 {
            color: #007bff; /* Consistent brand color */
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        h3 {
            color: #495057; /* Slightly darker heading */
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        p {
            line-height: 1.6;
            color: #555; /* Slightly muted text */
        }

        .img-fluid {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Team Section */
        .team-member {
            text-align: center;
            margin-bottom: 2rem;
        }

        .rounded-circle {
            border: 5px solid #007bff;
            margin-bottom: 1rem;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .rounded-circle:hover {
            transform: scale(1.1);
        }

        .team-member h5 {
            font-weight: 600;
            color: #343a40;
        }

        .team-member p {
            color: #777;
        }

        .mission-vision {
            background-color: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .about-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        /* Styles from index.php header/footer */
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

        footer {
            background-color: #007bff;
            color: #fff;
            padding: 2rem 0;
            text-align: center;
            margin-top: auto; /* Push the footer to the bottom */
        }

        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        footer a:hover {
            color: #f8f9fa;
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

<div class="container">
    <h2 class="text-center">About Us</h2>
    <p class="text-center text-muted">Learn more about our news portal and what we do.</p>

    <div class="row mt-4 about-section">
        <!-- About Section -->
        <div class="col-md-6">
            <h3>Who We Are</h3>
            <p>
                Welcome to our News Portal! We are dedicated to providing the latest and most relevant news across various categories.
                Our team works tirelessly to bring you accurate, unbiased, and timely news updates.
            </p>
        </div>

        <!-- Image Section -->
        <div class="col-md-6">
            <img src="assets/images/about.jpg" alt="About Us" class="img-fluid rounded">
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="row mt-5 mission-vision">
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>
                To provide high-quality journalism that informs, educates, and engages our audience.
                We strive to uphold the highest ethical standards in news reporting.
            </p>
        </div>
        <div class="col-md-6">
            <h3>Our Vision</h3>
            <p>
                To be the most trusted and go-to news source for people across the globe,
                ensuring accurate and timely updates on the most important topics.
            </p>
        </div>
    </div>

    <!-- Team Section (Optional) -->
    <div class="row mt-5">
        <h3 class="text-center">Meet Our Team</h3>
        <div class="col-md-4 team-member">
            <img src="assets/images/team1.jpg" class="rounded-circle" width="150" height="150" alt="John Doe">
            <h5>John Doe</h5>
            <p>Editor-in-Chief</p>
        </div>
        <div class="col-md-4 team-member">
            <img src="assets/images/team2.jpg" class="rounded-circle" width="150" height="150" alt="Jane Smith">
            <h5>Jane Smith</h5>
            <p>Senior Reporter</p>
        </div>
        <div class="col-md-4 team-member">
            <img src="assets/images/team3.jpg" class="rounded-circle" width="150" height="150" alt="Michael Brown">
            <h5>Michael Brown</h5>
            <p>Content Manager</p>
        </div>
    </div>
</div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-start">
                    © <?= date("Y") ?> News Portal
                </div>
                <div class="col-md-6 text-end">
                    <a href="privacy-policy.php">Privacy Policy</a> | <a href="terms-of-service.php">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close category result if it was used
if (isset($category_result) && $category_result !== false) {
  mysqli_free_result($category_result);
}
$conn->close(); // Ensure you close the connection
?>