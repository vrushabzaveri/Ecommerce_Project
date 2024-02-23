<?php
include "includes/db.php";
session_start();

// checks if user is logged in
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $get_customer = "SELECT * FROM customers WHERE customer_id='$customer_id'";
    $run_customer = mysqli_query($conn, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    if ($row_customer) {
        $customer_name = $row_customer['customer_name'];
    }
} else {
    header("Location: index.php");
    exit();
}

if (isset($_POST['submit_category'])) {
    $category_title = mysqli_real_escape_string($conn, $_POST['category_title']);

    if ($category_title == '') {
        echo "Please enter a category title";
    } else {
        $insert_category = "INSERT INTO categories (cat_title) VALUES ('$category_title')";
        $run_category = mysqli_query($conn, $insert_category);

        if ($run_category) {
            echo "<script>alert('Category has been added successfully!')</script>";
            echo "<script>window.open('insert_category.php','_self')</script>";
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
    <title>Insert New Category</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="header_wrapper text-center bg-dark text-light p-3">
        <h1>V-amazon</h1>
    </div>

    <div class="container mt-5">
        <h3>Welcome, <?php echo $customer_name; ?></h3>
        <form method="post" action="insert_category.php">
            <div class="card p-4">
                <h2 class="mb-4 text-left">Insert New Category</h2>
                <hr>

                <div class="mb-3">
                    <label for="category_title" class="form-label">Category Title</label>
                    <input type="text" class="form-control" name="category_title">
                </div>

                <button type="submit" class="btn btn-primary" name="submit_category">Insert Category</button>
            </div>
            <br>
            <a href="index.php"><button type="button" class="btn btn-primary" name="back">Back</button></a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
