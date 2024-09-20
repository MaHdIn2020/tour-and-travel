<?php
session_start();
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
$admin_id = $_SESSION['user_id'];
$book_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form data and escape to prevent SQL injection
    $card_name = $conn->real_escape_string($_POST['card_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // Retrieve book_id and admin_id from session
    $book_id = isset($_SESSION['book_id']) ? $_SESSION['book_id'] : null;
    $admin_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Assuming user_id is the admin ID


    // SQL query to insert the data
    $sql = "INSERT INTO payment (name_on_card, phone, card_num, amount, cvv, book_id, admin_id)
            VALUES ('$card_name', '$phone', '$card_number', '$amount', '$cvv','$book_id','$admin_id')";

if ($conn->query($sql) === TRUE) {
    // Get the last inserted ID
    $last_id = $conn->insert_id;

    // Prepare data for SSLCommerz
    $post_data = array();
    $post_data['store_id'] = "hifiv66eabaf453ef3";
    $post_data['store_passwd'] = "hifiv66eabaf453ef3@ssl";
    $post_data['total_amount'] = $amount;
    $post_data['currency'] = "BDT";
    $post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
    $post_data['success_url'] = "http://localhost/success.php";
    $post_data['fail_url'] = "http://localhost/fail.php";
    $post_data['cancel_url'] = "http://localhost/cancel.php";

    // Additional parameters and data here...

    $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $direct_api_url);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($handle, CURLOPT_POST, 1);
    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); // Keep it false if running from local PC

    $content = curl_exec($handle);
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    if ($code == 200 && !curl_errno($handle)) {
        curl_close($handle);
        $sslcommerzResponse = $content;

        // Parse the JSON response
        $sslcz = json_decode($sslcommerzResponse, true);

        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            // Redirect to the payment gateway
            echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
            exit;
        } else {
            echo "JSON Data parsing error!";
        }
    } else {
        curl_close($handle);
        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
        exit;
    }

    } else {
        // Display SQL errors
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="style1.css">

</head>
<body>

<div class="container">

    <form action="payment.php" method="POST">

        <div class="row">

            <!-- <div class="col">

                <h3 class="title">billing address</h3>

                <div class="inputBox">
                    <span>full name :</span>
                    <input type="text" name="full_name" placeholder="John Cena" required>
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" name="email" placeholder="example@example.com" required>
                </div>
                <div class="inputBox">
                    <span>address :</span>
                    <input type="text" name="address" placeholder="room - street - locality" required>
                </div>
                <div class="inputBox">
                    <span>city :</span>
                    <input type="text" name="city" placeholder="Dhaka" required>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>state :</span>
                        <input type="text" name="state" placeholder="Bangladesh" required>
                    </div>
                    <div class="inputBox">
                        <span>zip code :</span>
                        <input type="text" name="zip_code" placeholder="1216" required>
                    </div>
                </div>

            </div> -->

            <div class="col">

                <h3 class="title">payment</h3>

                <div class="inputBox">
                    <span>cards accepted :</span>
                    <img src="card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>name on card :</span>
                    <input type="text" name="card_name" placeholder="Mr. John Cena" required>
                </div>
                <div class="inputBox">
                    <span>Phone :</span>
                    <input type="text" name="phone" placeholder="013XXXXXXXX" required>
                </div>
                <div class="inputBox">
                    <span>credit card number :</span>
                    <input type="text" name="card_number" placeholder="1111-2222-3333-4444" required>
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Amount :</span>
                        <input type="number" name="amount" placeholder="500" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" name="cvv" placeholder="1234" required>
                    </div>
                </div>

            </div>
    
        </div>

        <input type="submit" value="Proceed to Checkout" class="submit-btn">

    </form>

</div>    
    
</body>
</html>
