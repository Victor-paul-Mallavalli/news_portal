<?php
// Ensure you have a db connection if needed for header/footer
include '../config/db.php';  // May not need this here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - News Portal</title>
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

        .container {
            max-width: 900px;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        h2 {
            color: #007bff;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        h3 {
            color: #495057;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        form {
            background: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        /* Styles from index.php for header and footer */
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
            margin-top: auto;
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

    <!-- Navbar (Assuming it's the same as index.php) -->
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

    <div class="container mt-5">
        <h2 class="text-center">Contact Us</h2>
        <p class="text-center text-muted">We’d love to hear from you. Reach out to us using the form below.</p>

        <div class="row mt-4">
            <!-- Contact Form -->
            <div class="col-md-6">
                <h3>Send Us a Message</h3>
                <form action="process_contact.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <!-- Contact Details -->
            <div class="col-md-6">
                <h3>Contact Information</h3>
                <p><strong>Address:</strong> Mylavaram, NTR district, Andhra Pradesh, India</p>
                <p><strong>Email:</strong> contact@newsportal.com</p>
                <p><strong>Phone:</strong> +1 234 567 890</p>

                <!-- Google Maps (Optional) -->
                <div class="mt-3">
                    <h4>Find Us on the Map</h4>
                     <iframe
                        width="100%" height="250"
                        frameborder="0" style="border:0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30562.970850303012!2d80.61950801599384!3d16.75819002761745!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a35dcd033ed3a21%3A0xdfc62e0009c36b6!2sMylavaram%2C%20Andhra%20Pradesh!5e0!3m2!1sen!2sin!4v1742980964086!5m2!1sen!2sin"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
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
//if(isset($conn)) $conn->close();  // Close the connection ONLY if it was opened on THIS page
?>