<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: user_login.php");
    exit();
}

if (isset($_GET['edit_product'])) {
    $edit_id = $_GET['edit_product'];
    $get_product = "SELECT * FROM products WHERE product_id='$edit_id'";
    $run_product = mysqli_query($conn, $get_product);

    if (!$run_product) {
        echo "Error fetching product details: " . mysqli_error($conn);
    } else {
        $row_product = mysqli_fetch_array($run_product);
        $product_id = $row_product['product_id'];
        $product_title = $row_product['product_title'];
        $product_cat = $row_product['cat_id'];
        $product_brand = $row_product['brand_id'];
        $product_price = $row_product['product_price'];
        $product_desc = $row_product['product_desc'];
        $product_img1 = $row_product['product_img1'];
        $product_img2 = $row_product['product_img2'];
        $product_img3 = $row_product['product_img3'];
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="styles/style.css" media="all" />
        </head>

        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_wrapper">
                            <div class="header_wrapper text-center bg-dark text-light p-3">
                                <h1>Edit Product</h1>
                                <a href="index.php" class="btn btn-primary">Back</a></div>

                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="row" style="padding: 15px;">
                                <div class="mb-3 col-sm-3">
                                    <label for="product_title" class="form-label">Product Title</label>
                                    <input type="text" class="form-control" name="product_title" value="<?php echo $product_title; ?>">
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="product_category" class="form-label">Select a Category</label>
                                    <select class="form-select" name="product_cat">
                                        <?php
                                        $get_cats = "SELECT * FROM categories";
                                        $run_cats = mysqli_query($conn, $get_cats);
                                        while ($row_cats = mysqli_fetch_array($run_cats)) {
                                            $cat_id = $row_cats['cat_id'];
                                            $cat_title = $row_cats['cat_title'];
                                            echo "<option value='$cat_id' ";
                                            if ($cat_id == $product_cat) {
                                                echo "selected";
                                            }
                                            echo ">$cat_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="product_brand" class="form-label">Select a Brand</label>
                                    <select class="form-select" name="product_brand">
                                        <?php
                                        $get_brands = "SELECT * FROM brands";
                                        $run_brands = mysqli_query($conn, $get_brands);
                                        while ($row_brands = mysqli_fetch_array($run_brands)) {
                                            $brand_id = $row_brands['brand_id'];
                                            $brand_title = $row_brands['brand_title'];
                                            echo "<option value='$brand_id' ";
                                            if ($brand_id == $product_brand) {
                                                echo "selected";
                                            }
                                            echo ">$brand_title</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="product_price" class="form-label">Product Price</label>
                                    <input type="text" class="form-control" name="product_price" value="<?php echo $product_price; ?>">
                                </div>
                                <hr>        
                                <div class="mb-3 col-sm-12">
                                    <label for="product_desc" class="form-label">Product Description</label>
                                    <textarea class="form-control" name="product_desc" rows="5"><?php echo $product_desc; ?></textarea>
                                </div>
                                <hr>       
                                <div class="mb-3 col-sm-3">
                                    <label for="product_img1" class="form-label">Product Image 1</label>
                                    <input type="file" class="form-control" name="product_img1">
                                    <img src='admin_area/product_images/<?php echo $product_img1; ?>' alt='Product Image 1' class="ImageFIle">
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="product_img2" class="form-label">Product Image 2</label>
                                    <input type="file" class="form-control" name="product_img2">
                                    <img src='admin_area/product_images/<?php echo $product_img2; ?>' alt='Product Image 2' class="ImageFIle">
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="product_img3" class="form-label">Product Image 3</label>
                                    <input type="file" class="form-control" name="product_img3">
                                    <img src='admin_area/product_images/<?php echo $product_img3; ?>' alt='Product Image 3' class="ImageFIle">
                                </div>
                                <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>         
                            </div>        
                                
                            </form>

                            <?php
                            // Handle form submission to update the product details
                            if (isset($_POST['update_product'])) {
                                $product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
                                $product_cat = mysqli_real_escape_string($conn, $_POST['product_cat']);
                                $product_brand = mysqli_real_escape_string($conn, $_POST['product_brand']);
                                $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
                                $product_desc = mysqli_real_escape_string($conn, $_POST['product_desc']);

                                $product_img1 = $_FILES['product_img1']['name'];
                                $product_img2 = $_FILES['product_img2']['name'];
                                $product_img3 = $_FILES['product_img3']['name'];

                                $temp_img1 = $_FILES['product_img1']['tmp_name'];
                                $temp_img2 = $_FILES['product_img2']['tmp_name'];
                                $temp_img3 = $_FILES['product_img3']['tmp_name'];

                                move_uploaded_file($temp_img1, "admin_area/product_images/$product_img1");
                                move_uploaded_file($temp_img2, "admin_area/product_images/$product_img2");
                                move_uploaded_file($temp_img3, "admin_area/product_images/$product_img3");

                                $update_product = "UPDATE products SET cat_id='$product_cat', brand_id='$product_brand', product_title='$product_title', product_price='$product_price', product_desc='$product_desc'";
                                
                                if (!empty($product_img1)) {
                                    $update_product .= ", product_img1='$product_img1'";
                                }
                                if (!empty($product_img2)) {
                                    $update_product .= ", product_img2='$product_img2'";
                                }
                                if (!empty($product_img3)) {
                                    $update_product .= ", product_img3='$product_img3'";
                                }

                                $update_product .= " WHERE product_id='$product_id'";
                                $run_update = mysqli_query($conn, $update_product);

                                if ($run_update) {
                                    echo "<h3 class='text-success'>Product updated successfully</h3>";
                                    echo '<script>window.location.replace("index.php");</script>';
                                    exit();
                                } else {
                                    echo "<div class='alert alert-danger'>Error updating product: " . mysqli_error($conn) . "</div>";
                                }
                            }
                            ?>

                            <div class="footer text-center bg-dark text-light p-3">
                                <h1>&copy; 2023-24 | Vrushab Zaveri</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
        <?php
    }
} else {
    echo "<div class='alert alert-danger'>Product ID not specified for editing.</div>";
}
?>
