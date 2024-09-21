<?php
session_start();
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

// Assuming user_id is stored in session upon login
$user_id = $_SESSION['user_id']; // Capture the logged-in user's ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the inputs
    $from_date = $conn->real_escape_string($_POST['from_date']);
    $to_date = $conn->real_escape_string($_POST['to_date']);
    $message = $conn->real_escape_string($_POST['message']);
    $selected_packages = $_POST['packages']; // Get selected packages

    foreach ($selected_packages as $pack_id) {
        // Fetch the package name using the pack_id
        $package_query = "SELECT pack_name FROM packages WHERE pack_id = '$pack_id'";
        $package_result = $conn->query($package_query);

        if ($package_result && $package_result->num_rows > 0) {
            $package_row = $package_result->fetch_assoc();
            $where_to = $conn->real_escape_string($package_row['pack_name']); // Use the package name here

            // Insert the booking details into the database for each package
            $sql = "INSERT INTO book (where_to, from_date, to_date, message, user_id) 
                    VALUES ('$where_to', '$from_date', '$to_date', '$message', '$user_id')";

            if ($conn->query($sql) === TRUE) {
                // Optionally handle successful insertion (e.g., store book_id for confirmation)
                $book_id = $conn->insert_id;

                // Now insert into confirms table
                $confirm_sql = "INSERT INTO Confirms (book_id, pack_id) VALUES ('$book_id', '$pack_id')";
                $conn->query($confirm_sql);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error fetching package name for pack_id: $pack_id<br>";
        }
    }

    // Redirect to payment page or display success message
    header("Location: payment.php");
    exit();
}

// Close the database connection
$conn->close();
?>
