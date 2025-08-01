<?php
session_start();
include '../config/db.php';

// Check if user is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    echo "❌ Access denied! Only admins can manage users.";
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
	//Prevent admin deletion
	$query = "SELECT role FROM users WHERE id = ?";
	$stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
	$stmt->execute();
	$getUserRole = $stmt->get_result()->fetch_assoc();

	if($getUserRole['role'] === 'admin') {
		echo "<p style='color:red;'>❌ Cannot delete another admin.</p>";
	} else {
		$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
		$stmt->bind_param("i", $user_id);
		if ($stmt->execute()) {
			echo "<p style='color:green;'>✅ User deleted successfully!</p>";
		} else {
			echo "<p style='color:red;'>❌ Error deleting user.</p>";
		}
		$stmt->close();
	}
}

// Handle role update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_role'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = $_POST['role'];
		//Prevent admin deletion
	$query = "SELECT role FROM users WHERE id = ?";
	$stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
	$stmt->execute();
	$getUserRole = $stmt->get_result()->fetch_assoc();
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Role updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error updating role.</p>";
    }
    $stmt->close();
}

// Fetch all users
$result = $conn->query("SELECT id, username, email, role FROM users ORDER BY role DESC, username ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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

        .form-select {
            border-radius: 0.25rem;
        }

        .btn-update {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-update:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            color: #dc3545;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }

        .btn-delete:hover {
            color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <?php
        if (isset($message)) {
            echo "<div class='alert alert-info'>" . $message . "</div>";
        }
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= intval($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= intval($row['id']) ?>">
                                <select class="form-select" name="role">
                                    <option value="reader" <?= $row['role'] === 'reader' ? 'selected' : '' ?>>Reader</option>
                                    <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>
                                <button type="submit" name="update_role" class="btn btn-update">
                                    <i class="fas fa-sync-alt"></i> Update
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="?delete=<?= intval($row['id']) ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">
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