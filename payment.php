<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form data and escape to prevent SQL injection
    $card_name = $conn->real_escape_string($_POST['card_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // SQL query to insert the data
    $sql = "INSERT INTO payment (name_on_card, phone, card_num, amount, cvv)
            VALUES ('$card_name', '$phone', '$card_number', '$amount', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted ID
        $last_id = $conn->insert_id;
        echo "Payment processed successfully! Your payment ID is: " . $last_id;
    } else {
        // Display SQL errors
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
