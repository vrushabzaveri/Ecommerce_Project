<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: user_login.php");
    exit();
}

// Check if the checkout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle payment processing here
    // Replace the following lines with actual payment gateway integration

    // Simulate successful payment
    $payment_status = 'success';

    if ($payment_status === 'success') {
        // If payment is successful, you can update the order status, save transaction details, etc.
        // For simplicity, let's assume updating the order status in the database.
        $update_order_status = "UPDATE orders SET order_status = 'Paid' WHERE customer_id = {$_SESSION['customer_id']}";

        // Check if the 'orders' table exists before attempting to update
        $check_orders_table = "SHOW TABLES LIKE 'orders'";
        $result = mysqli_query($conn, $check_orders_table);

        if (mysqli_num_rows($result) > 0) {
            mysqli_query($conn, $update_order_status);

            // Clear the cart after successful payment
            unset($_SESSION['cart']);

            // Redirect to a thank you page or order confirmation page
            header("Location: index.php.php");
            exit();
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>

<body>
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="main_wrapper">
                    <div class="header_wrapper text-center bg-dark text-light p-3">
                        <h1>V-amazon - Payment</h1>
                    </div>

                    <div class="payment_content">
                        <div id="payment_content" class="p-3">
                        <a href="cart.php"><button type="submit" class="btn btn-primary">Back</button></a>
                            <h2>Payment Details</h2>
                            <p>Total Amount: <?php echo isset($total_price) ? "$total_price INR" : "N/A"; ?></p>

                            <!-- Simulated payment form -->
                            <form action="payment.php" method="post">
                                <div class="form-group">
                                    <label for="card_number">Card Number:</label>
                                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                                </div>

                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date:</label>
                                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                                </div>

                                <div class="form-group">
                                    <label for="cvv">CVV:</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                                </div>

                                <!-- Add actual payment gateway fields here -->

                                <!-- Simulated submit button -->
                                <button type="submit" class="btn btn-primary">Pay Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
