<?php
session_start();
include '../config/db.php';

// Check admin access
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    echo "❌ Access denied!";
    exit();
}

if (!isset($_GET['id'])) {
    echo "❌ Article ID is required!";
    exit();
}

$article_id = intval($_GET['id']);

// Fetch existing article data
$query = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

if (!$article) {
    echo "❌ Article not found!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $image = $article['image'];

    // Handle image upload
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
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "<p style='color:red;'>❌ Error uploading image.</p>";
            exit;
        }
    }

    // Update article in DB
    $stmt = $conn->prepare("UPDATE articles SET title=?, content=?, category_id=?, image=? WHERE id=?");
    $stmt->bind_param("ssisi", $title, $content, $category_id, $image, $article_id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Article updated! Redirecting...</p>";
        header("refresh:2; url=manage_articles.php");
        exit;
    } else {
        echo "<p style='color:red;'>❌ Error updating article: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - Admin Panel</title>
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

        .img-thumbnail {
            max-width: 200px;
            height: auto;
            margin-bottom: 1rem;
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
        <h2>Edit Article</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
            </div>

            <div class="mb-3 ck-editor-container">
                <label for="content" class="form-label">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($article['content']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category:</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <?php
                    $cat_query = "SELECT * FROM categories";
                    $cat_result = $conn->query($cat_query);
                    while ($cat_row = $cat_result->fetch_assoc()) {
                        $selected = ($cat_row['id'] == $article['category_id']) ? "selected" : "";
                        echo "<option value='" . htmlspecialchars($cat_row['id']) . "'" . $selected . ">" . htmlspecialchars($cat_row['name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image:</label>
                <?php if ($article['image']) { ?>
                    <img src="../uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="img-thumbnail">
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Change Image:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Update Article</button>
        </form>
    </div>

    <script>
        CKEDITOR.replace('content');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>