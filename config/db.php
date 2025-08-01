<?php
// Database configuration
$host = "localhost";      // Change if using a remote database
$dbname = "news_portal";  // Your database name
$username = "root";       // Your MySQL username (default: root)
$password = "";           // Your MySQL password (default: empty)

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to avoid issues with special characters
$conn->set_charset("utf8");

?>
