<?php include '../config/db.php'; ?>
<?php include '../includes/header.php'; ?>

<?php
$id = $_GET['id'];
$article = $conn->query("SELECT articles.*, categories.name AS category FROM articles 
                         JOIN categories ON articles.category_id = categories.id WHERE articles.id = $id")->fetch_assoc();
?>

<div class="container mt-4">
    <h2><?php echo $article["title"]; ?></h2>
    <p><strong>Category:</strong> <?php echo $article["category"]; ?></p>
    <img src="../uploads/<?php echo $article['image']; ?>" class="img-fluid">
    <p><?php echo $article["content"]; ?></p>
</div>

<?php include '../includes/footer.php'; ?>
