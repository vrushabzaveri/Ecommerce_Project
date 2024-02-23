<?php include "includes/db.php" ?>



<!-- for products -->
<?php
function getPro()
{
    global $conn;

    if (!isset($_GET['cat'])) {
        $get_products = "SELECT * FROM products";
    } else {
        $cat_id = $_GET['cat'];
        $get_products = "SELECT * FROM products WHERE cat_id='$cat_id'";
    }

    $run_products = mysqli_query($conn, $get_products);

    while ($row_products = mysqli_fetch_array($run_products)) {
        $product_id = $row_products['product_id'];
        $product_title = $row_products['product_title'];
        $product_price = $row_products['product_price'];
        $product_img1 = $row_products['product_img1'];

        echo "<div class='col-md-4'>";
        echo "<div class='card mb-4 shadow-sm'>";
        echo "<img class='card-img-top' src='admin_area/product_images/$product_img1' alt='Product Image' style='height: 200px; object-fit: cover;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>$product_title</h5>";
        echo "<p><b>Price: $product_price INR</b></p>";
        echo "<div class='d-flex justify-content-between align-items-center'>";
        echo "<div class='btn-group'>";
        
        // details link outside the form
        echo "<a href='details.php?product_id=$product_id' class='btn btn-sm btn-outline-secondary'>Details</a>";

        // add to cart button
        echo "<form action='index.php' method='post' enctype='multipart/form-data'>"; 
        echo "<input type='hidden' name='product_id' value='$product_id'>";
        echo "<button type='submit' class='btn btn-sm btn-outline-secondary'>Add to Cart</button>";
        echo "</form>";

        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>
<!-- for brands -->
<?php
function getBrands()
{
    global $conn;

    $output = "";

    $get_brands = "SELECT * FROM brands";
    $run_brands = mysqli_query($conn, $get_brands);

    while ($row_brands = mysqli_fetch_array($run_brands)) {
        $brand_id = $row_brands['brand_id'];
        $brand_title = $row_brands['brand_title'];

        $output .= "<li><a href='index.php?brand=$brand_id'>$brand_title</a></li>";
    }

    echo $output;
}
?>

<?php

function getBrandsDropdown($selectedBrandTitle = '')
{
    global $conn;

    $output = "<select class='form-select' name='brand_id' required>";
    $output .= "<option value='' disabled selected>$selectedBrandTitle</option>";

    $get_brands = "SELECT * FROM brands";
    $run_brands = mysqli_query($conn, $get_brands);

    while ($row_brands = mysqli_fetch_array($run_brands)) {
        $brand_id = $row_brands['brand_id'];
        $brand_name = isset($row_brands['brand_title']) ? $row_brands['brand_title'] : '';
        $selected = ($brand_name == $selectedBrandTitle) ? "selected" : '';
        $output .= "<option value='$brand_id' $selected>$brand_name</option>";
    }

    $output .= "</select>";
    echo $output;
}

?>

<!-- for categories -->
<?php
function getCategories()
{
    global $conn;
    $get_categories = "SELECT * FROM categories";
    $run_categories = mysqli_query($conn, $get_categories);

    if (!$run_categories) {
        echo "Error fetching categories: " . mysqli_error($conn);
        return;
    }

    while ($row_categories = mysqli_fetch_array($run_categories)) {
        $cat_id = isset($row_categories['cat_id']) ? $row_categories['cat_id'] : null;
        $cat_title = isset($row_categories['cat_title']) ? $row_categories['cat_title'] : null;

        if ($cat_id !== null && $cat_title !== null) {
            echo "<li><a href='index.php?cat=$cat_id'>$cat_title</a></li>";
        } 
    }
}
?>

<?php 
function getAllBrands()
{
    global $conn;

    $get_brands = "SELECT * FROM brands";
    $run_brands = mysqli_query($conn, $get_brands);


    while ($row_brand = mysqli_fetch_array($run_brands)) {
        $brand_id = $row_brand['brand_id'];
        $brand_title = $row_brand['brand_title'];

        echo "<p><a href='brand.php?brand_id=" . urlencode($brand_id) . "'>$brand_title</a></p>";
    }
}
?>

<!-- for table css -->
<?php
function displayBrandsInTable()
{
    global $conn;

    $get_brands = "SELECT * FROM brands";
    $run_brands = mysqli_query($conn, $get_brands);

    echo '<table>';
    echo '<tr><th>Brand ID</th><th>Brand Title</th><th>Action</th></tr>';

    while ($row_brand = mysqli_fetch_array($run_brands)) {
        $brand_id = $row_brand['brand_id'];
        $brand_title = $row_brand['brand_title'];

        echo "<tr>";
        echo "<td>$brand_id</td>";
        echo "<td>$brand_title</td>";
        echo "<td>";
        //buttons
        echo "<a href='edit_brand.php?brand_id=$brand_id' class='btn btn-primary'>Edit Brand</a>";
        echo "&nbsp;";
        echo "<a href='view_brand.php?brand_id=$brand_id' class='btn btn-success'>View Brand</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo '</table>';
}
?>

<!-- for categories -->
<?php

function displayCategoriesInTable()
{
    global $conn;

    $get_cats = "SELECT * FROM categories";
    $run_cats = mysqli_query($conn, $get_cats);

    while ($row_cats = mysqli_fetch_array($run_cats)) {
        $cat_id = $row_cats['cat_id'];
        $cat_title = $row_cats['cat_title'];

        echo "<tr>
                <td>$cat_id</td>
                <td>$cat_title</td>
                <td>
                <a href='view_category.php?cat_id=$cat_id' class='btn btn-primary'>View Category</a>
                <a href='edit_category.php?cat_id=$cat_id' class='btn btn-warning'>Edit Category</a>
                </td>
            </tr>";
    }
}

?>

<?php
// Function to get total products in a category
function getTotalProductsInCategory($cat_id)
{
    global $conn;

    $get_total_products = "SELECT COUNT(*) as total FROM products WHERE cat_id='$cat_id'";
    $run_total_products = mysqli_query($conn, $get_total_products);
    $row_total_products = mysqli_fetch_array($run_total_products);

    return $row_total_products['total'];
}
?>
