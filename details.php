<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $get_product = "SELECT * FROM products WHERE product_id='$product_id'";
    $run_product = mysqli_query($conn, $get_product);

    if (!$run_product) {
        echo "Error fetching product details: " . mysqli_error($conn);
    } else {
        $row_product = mysqli_fetch_array($run_product);
        $product_title = $row_product['product_title'];
        $product_price = $row_product['product_price'];
        $product_img1 = $row_product['product_img1'];
        $product_img2 = $row_product['product_img2'];
        $product_img3 = $row_product['product_img3'];
        $product_desc = nl2br($row_product['product_desc']); // to preserve line breaks
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
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
                        <h1>Product Details</h1>
                    </div>

                    <div id="Navbar" class="bg-light">
                        <ul id="menu" class="nav">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <?php
                            //var_dump($_SESSION['customer_id']);die;
                            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == 1) {
                                echo '<li class="nav-item"><a class="nav-link" href="edit_product.php?edit_product=' . $product_id . '">Edit Product</a></li>';
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="content_wrapper">
                        <div id="product_details" class="p-3">
                            <h2><?php echo $product_title; ?></h2>
                            <p><b>Price: INR <?php echo $product_price; ?></b></p>
                            <img src='admin_area/product_images/<?php echo $product_img1; ?>' alt='Product Image 1' style='height: 200px; object-fit: cover;'>
                            <img src='admin_area/product_images/<?php echo $product_img2; ?>' alt='Product Image 2' style='height: 200px; object-fit: cover;'>
                            <img src='admin_area/product_images/<?php echo $product_img3; ?>' alt='Product Image 3' style='height: 200px; object-fit: cover;'>
                            <p><br>Product Description: <span><br><?php echo $product_desc; ?></span></p>
                            <a href="index.php" class="btn btn-primary">Back</a>
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