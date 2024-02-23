<?php
include "includes/db.php";

// Initialize variables
$message = "";

if (isset($_POST['submit'])) {
    // Get user input
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_pass = mysqli_real_escape_string($conn, $_POST['customer_pass']);
    
    $hashed_password = password_hash($customer_pass, PASSWORD_DEFAULT);

    // Insert user data into the database
    $insert_customer = "INSERT INTO customers (customer_name, customer_email, customer_pass) VALUES ('$customer_name', '$customer_email', '$hashed_password')";
    $run_customer = mysqli_query($conn, $insert_customer);

    // Display a message based on the registration result
    if ($run_customer) {
        // Set session variables for the registered user
        $_SESSION['customer_id'] = mysqli_insert_id($conn);
        $_SESSION['customer_email'] = $customer_email;

        $message = "User added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <form method="post" action="user_register.php">
            <div class="card p-4">
                <h2 class="mb-4 text-left">User Registration</h2>
                <hr>

                <?php if (!empty($message)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="customer_name">
                </div>

                <div class="mb-3">
                    <label for="customer_email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="customer_email">
                </div>

                <div class="mb-3">
                    <label for="customer_pass" class="form-label">Password</label>
                    <input type="password" class="form-control" name="customer_pass">
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Register</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
