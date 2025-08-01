<?php
session_start();
include '../config/db.php';

// Check if an article ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "❌ Invalid article!";
    exit();
}

$article_id = $_GET['id'];

// Fetch the article details
$stmt = $conn->prepare("SELECT a.*, c.name AS category, u.username AS author 
                        FROM articles a
                        LEFT JOIN categories c ON a.category_id = c.id
                        LEFT JOIN users u ON a.author_id = u.id
                        WHERE a.id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "❌ Article not found!";
    exit();
}

$article = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> - News Portal</title>
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
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin-top: 2rem;
        }

        h2 {
            color: #007bff;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        p {
            margin-bottom: 1rem;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .article-meta {
            margin-bottom: 1rem;
            font-style: italic;
            color: #6c757d;
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?= htmlspecialchars($article['title']) ?></h2>

        <p class="article-meta">
            <strong>Category:</strong> <?= htmlspecialchars($article['category'] ?? 'Uncategorized') ?> |
            <strong>Author:</strong> <?= htmlspecialchars($article['author'] ?? 'Unknown') ?> |
            <strong>Published:</strong> <?= date("F j, Y", strtotime($article['created_at'])) ?>
        </p>

        <?php if (!empty($article['image'])) { ?>
            <img src="../uploads/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        <?php } ?>

        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>

        <a href="index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to News
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
