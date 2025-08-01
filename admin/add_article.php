<?php
session_start();
include '../config/db.php';

// Check if user is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    echo "❌ Access denied! Only admins can add articles.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);

    // Validate the title
    if (empty($title)) {
        echo "<p style='color:red;'>❌ Title cannot be empty.</p>";
        exit; // Stop further processing
    }

    $content = $_POST['content'];  // Content now contains rich text (HTML)
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];
    $image = "";

    // Handle Image Upload
    if ($_FILES['image']['name']) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Basic file type validation
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<p style='color:red;'>❌ Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.</p>";
            exit;
        }

        // Move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "<p style='color:red;'>❌ Error uploading image.</p>";
            exit;
        }
    }

    // Insert article into the database
    $stmt = $conn->prepare("INSERT INTO articles (title, content, category_id, author_id, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $title, $content, $category_id, $author_id, $image);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Article added successfully! Redirecting...</p>";
        header("refresh:2; url=manage_articles.php"); // Redirect to manage_articles.php
        exit;
    } else {
        echo "<p style='color:red;'>❌ Error adding article: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Article - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            margin-top: 2rem;
            max-width: 800px;
        }

        h2 {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control,
        .form-select {
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .message {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            border-radius: 0.25rem;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* CKEditor Styling */
        .ck-editor-container {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add a New Article</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3 ck-editor-container">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category:</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php
                    // Fetch categories
                    $cat_query = "SELECT * FROM categories";
                    $cat_result = $conn->query($cat_query);
                    while ($cat_row = $cat_result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($cat_row['id']) . "'>" . htmlspecialchars($cat_row['name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Add Article</button>
        </form>
    </div>

    <script>
        CKEDITOR.replace('content');  // Enable CKEditor on the textarea
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php if(isset($stmt)) $stmt->close(); ?>
<?php $conn->close(); ?>