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
    <title>Brand Listing - V-amazon</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
    <style>
        table {
            border-collapse: collapse;
            width: 293%;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
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
                        <div class="brand_listing col-sm-4">
                            <h2>Brand Listing</h2>
                            <?php
                            displayBrandsInTable();
                            ?>
                        </div>
                    </div>
                    <a href="index.php"> <button type="submit" class="btn btn-primary" name="edit_brand">Back</button></a>
                </div>

            </div>

        </div>


    </div>
</body>

</html>