<?php
include "includes/db.php";
session_start();

//  if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $get_customer = "SELECT * FROM customers WHERE customer_id='$customer_id'";
    $run_customer = mysqli_query($conn, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    if ($row_customer) {
        $customer_name = $row_customer['customer_name'];
    }
} else {
    // Redirect to login page if the customer is not logged inb
    header("Location: index.php");
    exit();
}


if (isset($_POST['submit'])) {
    $brand_title = mysqli_real_escape_string($conn, $_POST['brand_title']);

    if ($brand_title == '') {
        echo "Please enter a brand title";
    } else {
        $insert_brand = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";
        $run_brand = mysqli_query($conn, $insert_brand);

        if ($run_brand) {
            echo "<script>alert('Brand has been added successfully!')</script>";
            echo "<script>window.open('insert_brand.php','_self')</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Brand</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
    <a href="index.php"><button type="button" class="btn btn-primary" name="back">Back</button></a>
        <h3>Welcome, <?php echo $customer_name; ?></h3> <!-- Display customer name -->
        <form method="post" action="insert_brand.php">
            <div class="card p-4">
                <h2 class="mb-4 text-left">Insert New Brand</h2>
                <hr>

                <div class="mb-3">
                    <label for="brand_title" class="form-label">Brand Title</label>
                    <input type="text" class="form-control" name="brand_title">
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Insert Brand</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>