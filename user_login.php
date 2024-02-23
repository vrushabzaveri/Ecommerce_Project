<?php
include "includes/db.php";

// Start a session
session_start();

// Check if the login form is submitted
if (isset($_POST['login'])) {
    // Get user input
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_pass = mysqli_real_escape_string($conn, $_POST['customer_pass']);

    // Retrieve user data from the database
    $get_customer = "SELECT * FROM customers WHERE customer_email='$customer_email'";
    $run_customer = mysqli_query($conn, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    // Check if the provided password matches the hashed password in the database
    if ($row_customer && password_verify($customer_pass, $row_customer['customer_pass'])) {
        // Set session variables for the logged-in user
        $_SESSION['customer_id'] = $row_customer['customer_id'];
        $_SESSION['customer_email'] = $row_customer['customer_email'];

        // Redirect to the index page after successful login
        header("Location: index.php");
    } else {
        echo "<script>alert('Invalid email or password!')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <form method="post" action="user_login.php">
            <div class="card p-4">
                <h2 class="mb-4 text-left">User Login</h2>
                <hr>

                <div class="mb-3">
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="customer_email">
                </div>

                <div class="mb-3">
                    <label for="customer_pass" class="form-label">Password</label>
                    <input type="password" class="form-control" name="customer_pass">
                </div>

                <button type="submit" class="btn btn-primary" name="login">Login</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
