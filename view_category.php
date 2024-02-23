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
    <title>View Category - V-amazon</title>
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
                        <div id="view_category">
                            <?php
                            if (isset($_GET['cat_id'])) {
                                $cat_id = $_GET['cat_id'];
                                $get_category = "SELECT * FROM categories WHERE cat_id='$cat_id'";
                                $run_category = mysqli_query($conn, $get_category);
                                $row_category = mysqli_fetch_array($run_category);

                                if ($row_category) {
                                    $cat_title = $row_category['cat_title'];

                                    echo '<h2>View Category</h2>';
                                    echo '<div class="table-responsive">';
                                    echo '<table class="table table-bordered">';
                                    echo '<tr><th>Category ID</th><td>' . $cat_id . '</td></tr>';
                                    echo '<tr><th>Category Title</th><td>' . $cat_title . '</td></tr>';
                                    echo '<tr><th>Total Products</th><td>' . getTotalProductsInCategory($cat_id) . '</td></tr>';
                                    echo '</table>';
                                    echo '</div>';
                                    echo '<a class="btn btn-primary" href="categories_listing.php?cat_id=' . $cat_id . '">Back to categoreis</a>';
                                    
                                } else {
                                    echo '<p>Category not found!</p>';
                                }
                            } else {
                                echo '<p>Invalid Category ID!</p>';
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
