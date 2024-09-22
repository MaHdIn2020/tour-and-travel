<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Payments</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php" class="active">Dashboard</a></li>
            <li><a href="login.html">Logout</a></li>
        </ul>
</div>
<div class="main-content">
        <header>
            <h1>Welcome, Admin</h1>
            <p>Control and manage all payments here.</p>
        </header>
    <section class="container">
        <h2>Admin Panel - Manage Payments</h2>

        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Name on Card</th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database Connection 
                $host = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbname = "project";
                
                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM payment";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name_on_card']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['amount']}</td>
                                <td>
                                    <form method='POST' action='admin_actions.php'>
                                        <input type='hidden' name='payment_id' value='{$row['id']}'>
                                        <button type='submit' name='approve'>Approve</button>
                                        <button type='submit' name='delete'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No payment records found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

    </>
</div>
</body>
</html>
