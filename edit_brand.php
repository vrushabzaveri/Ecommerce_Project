<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] != 1) {
    header("Location: index.php");
    exit();
}

// Handle brand editing
if(isset($_POST['edit_brand'])) {

    $selectedBrandId = $_POST['brand_id'];
    $newBrandName = $_POST['new_brand_name'];

    // Perform the update query
    $update_brand_query = "UPDATE brands SET brand_name = '$new_brand_name' WHERE brand_id = $brand_id";
    $run_update_brand = mysqli_query($conn, $update_brand_query);

    if (!$run_update_brand) {
        echo "Error updating brand: " . mysqli_error($conn);
    } else {
        echo "Brand updated successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>

<body>
    <div class="header_wrapper text-center bg-dark text-light p-3">
        <h1>V-amazon</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="main_wrapper">
                    <div id="Navbar" class="bg-light">
                        <ul id="menu" class="nav">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <?php
                            if (isset($_SESSION['customer_id'])) {
                                $customer_id = $_SESSION['customer_id'];
                                $get_customer = "SELECT * FROM customers WHERE customer_id='$customer_id'";
                                $run_customer = mysqli_query($conn, $get_customer);
                                $row_customer = mysqli_fetch_array($run_customer);
                                // admin query here
                                if ($row_customer) {
                                    $customer_name = $row_customer['customer_name'];
                                    echo '<li class="nav-item"><span class="nav-link">Welcome, '  . $customer_name .  '!</span></li>';
                                    if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 1) {
                                        echo '<li class="nav-item"><a class="nav-link" href="insert_product.php">Insert Product</a></li>';
                                        echo '<li class="nav-item"><a class="nav-link" href="brand_listing.php">Brands</a></li>';
                                        echo '<li class="nav-item"><a class="nav-link" href="insert_category.php">Insert Category</a></li>';
                                        echo '<li class="nav-item"><a class="nav-link" href="edit_category.php">Edit Category</a></li>';
                                    }
                                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                                }
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="user_login.php">Login</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="user_register.php">Signup</a></li>';
                            }

                            //cart primaryrmation in the navbar
                            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                $totalItems = array_sum($_SESSION['cart']);
                                echo '<li class="nav-item"><a class="nav-link" href="cart.php">Cart (' . $totalItems . ' items)</a></li>';
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="cart.php">Cart (0 items)</a></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="container mt-5">
                        <h2>Edit Brand</h2>
                        <form method="post" action="edit_brand.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="brand_id" class="form-label"></label>
                                <?php getBrandsDropdown($brand_title); ?>
                            </div>
                            <div class="mb-3">
                                <label for="brand_title" class="form-label">New Brand Title</label>
                                <input type="text" class="form-control" name="new_brand_name" required>
                                
                            </div>
                            <button type="submit" class="btn btn-primary" name="edit_brand">Edit Brand</button>
                            <a href="brand_listing.php" class="btn btn-primary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>