<?php
include "includes/db.php";
include "functions/functions.php";
session_start();


if (!isset($_SESSION['customer_id'])) {
    header("Location: user_login.php");
    exit();
}

// Check if the update cart form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    // Handle product removal
    if (isset($_POST['remove'])) {
        foreach ($_POST['remove'] as $key => $value) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>

<body>
    <div class="container-lg">
        <div class="row">
            <div class="col-md-12">
                <div class="main_wrapper">
                    <div class="header_wrapper text-center bg-dark text-light p-3">
                        <a href="index.php"><h1>V-amazon - My Cart</h1></a>
                    </div>
                    
                    <div class="cart_content">
                        <div id="cart_content" class="p-3">
                            <?php
                            if (!empty($_SESSION['cart'])) {
                                echo "<form action='cart.php' method='post' enctype='multipart/form-data'>";
                                echo "<div class='table-responsive'>";
                                echo "<table class='table table-bordered'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th scope='col'>Product</th>";
                                echo "<th scope='col'>Quantity</th>";
                                echo "<th scope='col'>Price</th>";
                                echo "<th scope='col'>Remove</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                $total_price = 0;
                                //for cart count inc
                                foreach ($_SESSION['cart'] as $key => $value) {
                                    $product_id = $key;
                                    $get_products = "SELECT * FROM products WHERE product_id='$product_id'";
                                    $run_products = mysqli_query($conn, $get_products);

                                    while ($row_products = mysqli_fetch_array($run_products)) {
                                        $product_title = $row_products['product_title'];
                                        $product_price = $row_products['product_price'];

                                        $subtotal = $product_price * $value;
                                        $total_price += $subtotal;

                                        echo "<tr>";
                                        echo "<td>$product_title</td>";
                                        echo "<td>$value</td>";
                                        echo "<td>$product_price INR</td>";
                                        echo "<td><input type='checkbox' name='remove[$product_id]' value='Remove'></td>";
                                        echo "</tr>";
                                    }
                                }

                                echo "</tbody>";
                                echo "</table>";
                                echo "</div>";

                                echo "<div class='d-flex justify-content-end'>";
                                echo "<p><b>Total Price: $total_price INR</b></p>";
                                echo "</div>";

                                echo "<div class='d-flex justify-content-end'>";
                                echo "<a href='index.php' class='btn btn-warning'>Back</a>";

                                // if items r in cart or not
                                if (!empty($_SESSION['cart'])) {
                                    echo "<button type='submit' name='update_cart' class='btn btn-success'>Update Cart</button>";
                                    echo "<a href='payment.php' class='btn btn-warning'>Proceed to Payment</a>";
                                }
                                
                                echo "</div>";
                                echo "</form>";
                            } else {
                                echo "<p>Your cart is empty. Add some items <a href='index.php'>here</a>.</p>";
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
