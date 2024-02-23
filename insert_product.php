<?php
include "includes/db.php";
session_start();

// Check if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $get_customer = "SELECT * FROM customers WHERE customer_id='$customer_id'";
    $run_customer = mysqli_query($conn, $get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    if ($row_customer) {
        $customer_name = $row_customer['customer_name'];
    }
} else {
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
</head>

<body class="bg-light">
    <div class="header_wrapper text-center bg-dark text-light p-3">
        <h1>V-amazon</h1>
    </div>
    
    <div class="container mt-5">
        <h3>Welcome, <?php echo $customer_name; ?></h3>
        <form method="post" action="insert_product.php" enctype="multipart/form-data">
            <div class="card p-4">
                <h2 class="mb-4 text-left">Insert New Product</h2>
                <hr>

                <div class="mb-3">
                    <label for="product_title" class="form-label">Product Title</label>
                    <input type="text" class="form-control" name="product_title">
                </div>

                <div class="mb-3">
                    <label for="product_category" class="form-label">Select a Category</label>
                    <select class="form-select" name="product_cart">
                        <option>Select a Category</option>
                        <?php
                        $get_cats = "SELECT * FROM categories";
                        $run_cats = mysqli_query($conn, $get_cats);
                        while ($row_cats = mysqli_fetch_array($run_cats)) {
                            echo '<option value="' . $row_cats['cat_id'] . '">' . $row_cats['cat_title'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="product_brand" class="form-label">Select a Brand</label>
                    <select class="form-select" name="product_brand">
                        <option>Select a Brand</option>
                        <?php
                        $get_brands = "SELECT * FROM brands";
                        $run_brands = mysqli_query($conn, $get_brands);
                        while ($row_brands = mysqli_fetch_array($run_brands)) {
                            echo '<option value="' . $row_brands['brand_id'] . '">' . $row_brands['brand_title'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="product_img1" class="form-label">Product Image 1</label>
                    <input type="file" class="form-control" name="product_img1">
                </div>

                <div class="mb-3">
                    <label for="product_img2" class="form-label">Product Image 2</label>
                    <input type="file" class="form-control" name="product_img2">
                </div>

                <div class="mb-3">
                    <label for="product_img3" class="form-label">Product Image 3</label>
                    <input type="file" class="form-control" name="product_img3">
                </div>

                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="text" class="form-control" name="product_price">
                </div>

                <div class="mb-3">
                    <label for="product_desc" class="form-label">Product Description</label>
                    <textarea class="form-control" name="product_desc" rows="5"></textarea>
                </div>

                <div class="mb-3">
                    <label for="product_keywords" class="form-label">Product Keywords</label>
                    <input type="text" class="form-control" name="product_keywords">
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Insert Product</button>
            </div>
            <br>
            <a href="index.php"><button type="button" class="btn btn-primary" name="back">Back</button></a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
include "includes/db.php";

if (isset($_POST['submit'])) {

    $product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
    $product_cat = mysqli_real_escape_string($conn, $_POST['product_cart']);
    $product_brand = mysqli_real_escape_string($conn, $_POST['product_brand']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_desc = mysqli_real_escape_string($conn, $_POST['product_desc']);
    $status = 'on';
    $product_keywords = mysqli_real_escape_string($conn, $_POST['product_keywords']);

    // Image names
    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_img3 = $_FILES['product_img3']['name'];

    // Image temp names
    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];
    $temp_name3 = $_FILES['product_img3']['tmp_name'];

    if ($product_title == '' or $product_cat == '' or $product_brand == '' or $product_price == '' or $product_desc == '' or $product_keywords == '' or $product_img1 == '') {
        echo "Please fill all the fields";
    } else {

        // Upload images to folder
        move_uploaded_file($temp_name1, "admin_area/product_images/$product_img1");
        move_uploaded_file($temp_name2, "admin_area/product_images/$product_img2");
        move_uploaded_file($temp_name3, "admin_area/product_images/$product_img3");

        // Insert product into the database
        $insert_product = "INSERT INTO products (cat_id, brand_id, date, product_title, product_img1, product_img2, product_img3, product_price, product_desc, status)
         VALUES ('$product_cat', '$product_brand', NOW(), '$product_title', '$product_img1', '$product_img2', '$product_img3', '$product_price', '$product_desc', '$status')";

        $run_product = mysqli_query($conn, $insert_product);

        if ($run_product) {
            echo "<h3>Product entered successfully<h3>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
