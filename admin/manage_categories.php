<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    die("❌ Access Denied!");
}

// Fetch categories
$result = $conn->query("SELECT * FROM categories");

// Add Category
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    if (!empty($name)) {
		//Prevent adding duplicate names
		$query = "SELECT * FROM categories WHERE name = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$checkCategory = $stmt->get_result();
		if($checkCategory->num_rows > 0){
			echo "<p style='color:red;'>❌ Category name already exists.</p>";
		} else {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        header("Location: manage_categories.php");
		}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        .container {
            margin-top: 2rem;
        }

        h2 {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-back {
            margin-bottom: 1rem;
            display: inline-block;
            text-decoration: none;
            color: #007bff;
            transition: color 0.2s ease-in-out;
        }

        .btn-back:hover {
            color: #0056b3;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .table {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            vertical-align: middle;
            border-color: #dee2e6;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .delete-link {
            color: #dc3545;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .delete-link:hover {
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Categories</h2>
        <a href="index.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
        </a>

        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-add">
                <i class="fas fa-plus"></i> Add Category
            </button>
        </form>

        <hr>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <a href="delete_category.php?id=<?= intval($row['id']) ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this category?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>