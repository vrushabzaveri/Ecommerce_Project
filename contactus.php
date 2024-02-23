<?php
include "includes/db.php";
include "functions/functions.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css" media="all" />
</head>

<body>
<div class="main_wrapper">
                    <div class="header_wrapper text-center bg-dark text-light p-3">
                        <h1>V-amazon</h1>
                    </div>
    <div class="container mt-5">
        <h2 class="mb-4">Contact Us</h2>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $message = $_POST["message"];


            $query = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $name, $email, $message);
            $runquery = $stmt->execute();

            //succesful
            if ($runquery) {
                echo "Data inserted successfully!";
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        
            $stmt->close();
            $conn->close();
        }
        ?>



            <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="4"></textarea>

            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="index.php"><button type="submit" class="btn btn-primary">Back</button></a>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>