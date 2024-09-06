<?php
// Database connection credentials
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project"; // Your database name

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the inputs and escape them to prevent SQL injection
    $destination = $conn->real_escape_string($_POST['destination']);
    $from_date = $conn->real_escape_string($_POST['from_date']); // Already in 'YYYY-MM-DD' format
    $to_date = $conn->real_escape_string($_POST['to_date']);     // Already in 'YYYY-MM-DD' format
    $message = $conn->real_escape_string($_POST['message']);

    // Insert the data into the database
    $sql = "INSERT INTO bookings (destination, from_date, to_date, message) 
            VALUES ('$destination', '$from_date', '$to_date', '$message')";

    if ($conn->query($sql) === TRUE) {
        header("Location: payment.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
