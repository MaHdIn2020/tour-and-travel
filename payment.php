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
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $zip_code = $conn->real_escape_string($_POST['zip_code']);
    $card_name = $conn->real_escape_string($_POST['card_name']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $exp_month = $conn->real_escape_string($_POST['exp_month']);
    $exp_year = $conn->real_escape_string($_POST['exp_year']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // SQL query to insert the data
    $sql = "INSERT INTO payments (full_name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv)
            VALUES ('$full_name', '$email', '$address', '$city', '$state', '$zip_code', '$card_name', '$card_number', '$exp_month', '$exp_year', '$cvv')";

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
