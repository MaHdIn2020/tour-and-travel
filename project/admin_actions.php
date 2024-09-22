<?php
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection 
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$admin_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];
    if (isset($_POST['approve'])) {
        $sql = "UPDATE payment SET status = 'approved', admin_id = '$admin_id' WHERE id = $payment_id";
        if ($conn->query($sql) === TRUE) {
            echo "Payment with ID $payment_id approved successfully.";
        } else {
            echo "Error approving payment: " . $conn->error;
        }

    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM payment WHERE id = $payment_id";
        if ($conn->query($sql) === TRUE) {
            echo "Payment with ID $payment_id deleted successfully.";
        } else {
            echo "Error deleting payment: " . $conn->error;
        }
    }
}

header("Location: admin.php");
$conn->close();
?>
