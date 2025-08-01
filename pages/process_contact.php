<?php
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Error sending message. Try again later.'); window.location.href='contact.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('All fields are required!'); window.location.href='contact.php';</script>";
    }

    $conn->close();
}
?>
