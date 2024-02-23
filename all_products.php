<?php
include "includes/db.php";
include "functions/functions.php";

if (isset($_GET['brand'])) {
    $brand_id = $_GET['brand'];
    $get_products = "SELECT * FROM products WHERE brand_id='$brand_id'";
} elseif (isset($_GET['cat'])) {
    $cat_id = $_GET['cat'];
    $get_products = "SELECT * FROM products WHERE cat_id='$cat_id'";
} else {
    $get_products = "SELECT * FROM products";
}

$run_products = mysqli_query($conn, $get_products);

if (!$run_products) {
    echo "Error fetching products: " . mysqli_error($conn);
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Project</title>
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
                        <h1>My Shop</h1>
                    </div>

                    <div id="Navbar" class="bg-light">
                        <ul id="menu" class="nav">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="all_products.php">All Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="my_account.php">My Account</a></li>
                            <li class="nav-item"><a class="nav-link" href="user_register.php">Signup</a></li>
                            <li class="nav-item"><a class="nav-link" href="card.php">Shopping Cart</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                        </ul>
                    </div>

                    <div class="content_wrapper">
                        <div id="right_content" class="p-3">
                            <div id="products_box" class="row">
                                <?php getPro(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="footer text-center bg-dark text-light p-3">
                        <h1>&copy; 2023-24 | Vrushab Zaveri</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
