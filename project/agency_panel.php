<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "project";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the agency is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'agency') {
    header("Location: login.html");
    exit();
}

$agency_id = $_SESSION['user_id']; // Get agency ID from session

// Handle form submission to add a new package
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_package'])) {
    $package_name = $_POST['pack_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image'];

    // Insert package with agency_id
    $sql = "INSERT INTO packages (pack_name, description, price, image, agency_id) VALUES ('$package_name', '$description', '$price', '$image_url', '$agency_id')";

    if ($conn->query($sql) === TRUE) {
        // Optional: Display a success message
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle package deletion
if (isset($_GET['delete'])) {
    $pack_name = $_GET['delete'];
    $sql = "DELETE FROM packages WHERE pack_name='$pack_name'";

    if ($conn->query($sql) === TRUE) {
        // Optional: Display a success message
    } else {
        echo "Error deleting package: " . $conn->error;
    }
}

// Fetch all packages for display
$result = $conn->query("SELECT * FROM packages WHERE agency_id='$agency_id'");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Panel</title>
    <link href="agency_panel.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Agency Panel</h1>
    <h2>Add New Package</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="pack_name" class="form-label">Package Name</label>
            <input type="text" class="form-control" id="pack_name" name="pack_name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-primary" name="add_package">Add Package</button>
    </form>

    <h2 class="mt-5">Existing Packages</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['pack_name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td>
                    <a href="agency_panel.php?delete=<?php echo $row['pack_name']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
