<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

// Handle adding products to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (!isset($_SESSION['cart'])) {    
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-amazon</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="main_wrapper">
                    <div class="header_wrapper text-center bg-dark text-light p-3">
                        <h1>V-amazon</h1>
                    </div>

                    <!-- Navbar -->
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
                                        echo '<li class="nav-item"><a class="nav-link" href="insert_category.php">Insert Category</a></li>';
                                        echo '<li class="nav-item"><a class="nav-link" href="brand_listing.php">Brands</a></li>';
                                        echo '<li class="nav-item"><a class="nav-link" href="categories_listing.php">Categories</a></li>';
                                    }     
                                    
                                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                                }
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="user_login.php">Login</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="user_register.php">Signup</a></li>';
                            }

                            // Cart link with item count
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
                        <div id="left_sidebar" class="p-3">
                            <div id="sidebar_title">Categories</div>
                            <ul id="cats" class="list-unstyled">
                                <?php getCategories(); ?>
                            </ul>

                            <div id="sidebar_title">Brands</div>
                            <ul id="brands" class="list-unstyled">
                                <?php getBrands(); ?>
                            </ul>
                        </div>

                        <div id="right_content" class="p-3">
                            <div id="products_box" class="row">
                                <?php getPro(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="footer text-center bg-dark text-light p-3">
                        <a href="contactus.php">
                            <h4>Contact Us</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
