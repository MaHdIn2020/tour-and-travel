<?php
$servername = "localhost";  // Change this if you're using a different host
$username = "root";         // Update with your DB username
$password = "";             // Update with your DB password
$dbname = "project";        // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>