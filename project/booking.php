<?php
session_start();
// Database connection 
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project"; 

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$user_id = $_SESSION['user_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the inputs
    $from_date = $conn->real_escape_string($_POST['from_date']);
    $to_date = $conn->real_escape_string($_POST['to_date']);
    $message = $conn->real_escape_string($_POST['message']);
    $selected_packages = $_POST['packages']; 
    if (strtotime($to_date) <= strtotime($from_date)) {
        $_SESSION['error_message'] = "Error: To date must be greater than From date.";
        header("Location: home.php");
        exit();
    }

    $_SESSION['book_ids'] = [];
    $_SESSION['total_amount'] = 0;

    foreach ($selected_packages as $pack_id) {
        
        $package_query = "SELECT pack_name, price FROM packages WHERE pack_id = '$pack_id'";
        $package_result = $conn->query($package_query);

        if ($package_result && $package_result->num_rows > 0) {
            $package_row = $package_result->fetch_assoc();
            $where_to = $conn->real_escape_string($package_row['pack_name']);
            $price = $package_row['price']; 
            $_SESSION['total_amount'] += $price; 

            $sql = "INSERT INTO book (where_to, from_date, to_date, message, user_id) 
                    VALUES ('$where_to', '$from_date', '$to_date', '$message', '$user_id')";

            if ($conn->query($sql) === TRUE) {

                $book_id = $conn->insert_id;
                $_SESSION['book_ids'][] = $book_id;

                $confirm_sql = "INSERT INTO Confirms (book_id, pack_id) VALUES ('$book_id', '$pack_id')";
                $conn->query($confirm_sql);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error fetching package name for pack_id: $pack_id<br>";
        }
    }

    header("Location: payment.php");
    exit();
}


$conn->close();
?>
