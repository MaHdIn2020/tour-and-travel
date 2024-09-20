<?php
// Database connection credentials
session_start();
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
    $sql = "INSERT INTO book (where_to, from_date, to_date, message) 
            VALUES ('$destination', '$from_date', '$to_date', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted booking ID
        $book_id = $conn->insert_id;

        // Store the book_id in session for use in payment
        $_SESSION['book_id'] = $book_id;
        header("Location: payment.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
