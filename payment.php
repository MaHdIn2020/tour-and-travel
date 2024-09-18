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
    $card_name = $conn->real_escape_string($_POST['card_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $card_number = $conn->real_escape_string($_POST['card_number']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $cvv = $conn->real_escape_string($_POST['cvv']);

    // SQL query to insert the data
    $sql = "INSERT INTO payment (name_on_card, phone, card_num, amount, cvv)
            VALUES ('$card_name', '$phone', '$card_number', '$amount', '$cvv')";

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
