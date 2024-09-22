<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $category = $conn->real_escape_string($_POST['category']); 

    if (empty($username) || empty($password)) {
        echo "<div class='error'>Please fill in all fields!</div>";
    } else {
        
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND usertype='$category'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            
            $row = $result->fetch_assoc();
            
            $_SESSION['username'] = $row['username'];
            $_SESSION['usertype'] = $row['usertype'];
            $_SESSION['user_id'] = $row['id']; 
            
            switch ($row['usertype']) {
                case 'user':
                    header("Location: home.php");
                    break;
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'agency':
                    header("Location: agency_panel.php");
                    break;
            }
            exit();
        } else {
            echo "<div class='error'>Invalid username, password, or usertype!</div>";
            header("refresh:2;url=login.html"); 
        }
    }
}

$conn->close();
?>
