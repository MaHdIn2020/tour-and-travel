<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve the amount from the query string
$amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Payment Confirmation</h1>
        <p class="amount">Amount: $<span id="amount"><?php echo $amount;?></span></p>
        <p>Are you sure you want to proceed with the payment?</p>
        <div class="buttons">
            <form action="checkout.php" method="get">
            <button class="confirm-btn">Yes, Proceed</button>
            </form>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>
</body>
</html>
