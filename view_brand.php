<!-- view_brand.php -->

<?php
include "includes/db.php";
include "functions/functions.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Brand - V-amazon</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

                            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                $totalItems = array_sum($_SESSION['cart']);
                                echo '<li class="nav-item"><a class="nav-link" href="cart.php">Cart (' . $totalItems . ' items)</a></li>';
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="cart.php">Cart (0 items)</a></li>';
                            }
                            ?>

                        </ul>
                    </div>

                    <div class="content_wrapper">
                        <div id="view_brand">
                            <?php
                            if (isset($_GET['brand_id'])) {
                                $brand_id = $_GET['brand_id'];

                                //  brand details
                                $get_brand = "SELECT * FROM brands WHERE brand_id='$brand_id'";
                                $run_brand = mysqli_query($conn, $get_brand);
                                $row_brand = mysqli_fetch_array($run_brand);

                                if ($row_brand) {
                                    $brand_title = $row_brand['brand_title'];

                                    //  total quantity of products for the brand
                                    $get_total_quantity = "SELECT COUNT(*) AS total_quantity FROM products WHERE brand_id='$brand_id'";
                                    $run_total_quantity = mysqli_query($conn, $get_total_quantity);
                                    $row_total_quantity = mysqli_fetch_array($run_total_quantity);
                                    $total_quantity = $row_total_quantity['total_quantity'];

                                    echo '<h2>View Brand</h2>';
                                    echo '<div class="table-responsive">';
                                    echo '<table class="table table-bordered">';
                                    echo '<tr><th>Brand ID</th><td>' . $brand_id . '</td></tr>';
                                    echo '<tr><th>Brand Title</th><td>' . $brand_title . '</td></tr>';
                                    echo '<tr><th>Total Products</th><td>' . $total_quantity . '</td></tr>';
                                    echo '</table>';
                                    echo '</div>';

                                    echo '<a class="btn btn-primary" href="brand_listing.php">Back to Brands</a>';
                                } else {
                                    echo '<p>Brand not found!</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
