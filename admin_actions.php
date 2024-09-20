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

// Check if an action is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];

    if (isset($_POST['approve'])) {
        // Approve payment (for this example, you might just log the approval)
        $sql = "UPDATE payment SET status = 'approved' WHERE id = $payment_id";
        if ($conn->query($sql) === TRUE) {
            echo "Payment with ID $payment_id approved successfully.";
        } else {
            echo "Error approving payment: " . $conn->error;
        }

    } elseif (isset($_POST['delete'])) {
        // Delete the payment record
        $sql = "DELETE FROM payment WHERE id = $payment_id";
        if ($conn->query($sql) === TRUE) {
            echo "Payment with ID $payment_id deleted successfully.";
        } else {
            echo "Error deleting payment: " . $conn->error;
        }
    }
}

// Redirect back to admin panel
header("Location: admin.php");
$conn->close();
?>
