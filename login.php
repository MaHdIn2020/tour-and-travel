<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $category = $_POST['category'];

    if (empty($username) || empty($password)) {
        echo "<div class='error'>Please fill in all fields!</div>";
      } 
    else {
        // SQL query to fetch user data
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND usertype='$category'";
        $result = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($result) > 0) {
          // Login successful (replace with session management or redirection)
          header("Location: home.php");
          exit();
          // ... handle successful login (e.g., start a session or redirect)
        } else {
          echo "<div class='error'>Invalid username, password, or category!</div>";
          header("Location: login.html");
        }
      }
    }
    

$conn->close();
?>
