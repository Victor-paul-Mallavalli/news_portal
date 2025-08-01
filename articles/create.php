<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("❌ Access Denied!");
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Insert article
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO articles (title, content, category_id, author_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $content, $category_id, $author_id);
    $stmt->execute();

    header("Location: ../admin/manage_articles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Article</title>
</head>
<body>
    <h2>Add New Article</h2>
    <a href="../admin/manage_articles.php">🔙 Back to Articles</a>
    <hr>

    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required><br>

        <label>Content:</label>
        <textarea name="content" required></textarea><br>

        <label>Category:</label>
        <select name="category_id" required>
            <?php while ($cat = $categories->fetch_assoc()) { ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
            <?php } ?>
        </select><br>

        <button type="submit">➕ Add Article</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
