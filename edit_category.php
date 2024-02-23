<?php
include "includes/db.php";
include "functions/functions.php";
session_start();

if (!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] != 1) {
    header("Location: index.php");
    exit();
}

// Assuming you have a function to get the category details based on the category ID
function getCategoryDetails($category_id)
{
    global $conn;

    $get_category_query = "SELECT * FROM categories WHERE cat_id='$category_id'";
    $run_category = mysqli_query($conn, $get_category_query);

    if (!$run_category) {
        echo "Error fetching category details: " . mysqli_error($conn);
        return null;
    }

    return mysqli_fetch_array($run_category);
}

if (isset($_POST['edit_category'])) {
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['new_category_name'];

     $update_category_query = "UPDATE categories SET cat_title = '$new_category_name' WHERE cat_id = $category_id";
     mysqli_query($conn, $update_category_query);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<div class="header_wrapper text-center bg-dark text-light p-3">
                        <h1>V-amazon</h1>
                    </div>
    <div class="container mt-5">
        
        <h2>Edit Category</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="category_id" class="form-label">Select Category to Edit</label>
                <select class="form-select" name="category_id" required>
                    <?php getCategories (); ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_category_name" class="form-label">New Category Name</label>
                <input type="text" class="form-control" name="new_category_name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="edit_category">Edit Category</button>
            <a href="categories_listing.php" class="btn btn-primary">Back</a>
        </form>
    </div>
</body>

</html>

<?php
        // Display selected category details
        if (isset($_POST['category_id'])) {
            $selectedCategoryID = $_POST['category_id'];
            $selectedCategoryDetails = getCategoryDetails($selectedCategoryID);

            if ($selectedCategoryDetails) {
                echo "<h3>Selected Category Details:</h3>";
                echo "<p>Category ID: " . $selectedCategoryDetails['cat_id'] . "</p>";
                echo "<p>Category Title: " . $selectedCategoryDetails['cat_title'] . "</p>";
                // Add other category details as needed
            }
        }
        ?>
