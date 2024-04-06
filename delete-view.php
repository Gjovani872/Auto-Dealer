<?php
include "conn/connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login-view.php");
    exit();
}

$imageId = $_GET['id'];

$query = "SELECT * FROM vehicles WHERE id = $imageId";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $imageURL = $row['image_url'];
    $description = $row['description'];
    $year = $row['year'];
    $price = $row['price'];
    $mileage = $row['mileage'];
    $userId = $row['user_id'];
    ?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style/deleteview.css">
        <title>Delete Ad</title>
    </head>

    <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h2>Are you sure you want to delete this ad?</h2>
                    <div class="image-wrapper">
                        <img src="<?php echo $imageURL; ?>" alt="<?php echo $title; ?>">
                    </div>
                    <div class="image-details">
                        <h2><?php echo $title; ?></h2>
                        <p class="description"><?php echo "Description: " . $description; ?></p>
                        <p><?php echo "Year: " . $year; ?></p>
                        <p><?php echo "Mileage: " . $mileage; ?></p>
                        <p class="price"><?php echo "Price: " . $price; ?></p>
                        <div class="edit-delete-buttons">
                            <button id="delete-btn" class="btn btn-danger">Yes</button>
                            <button id="cancel-btn" class="btn btn-secondary">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#delete-btn").click(function () {
                $.ajax({
                    type: "POST",
                    url: "delete.php",
                    data: {id: "<?php echo $imageId; ?>"}, //vehicle id koji smo preko geta
                    success: function (response) {

                        console.log(response);
                        alert('Ad has been succesfully deleted: ')
                        // Redirektuj na start-view.php stranicu
                        window.location.href = "start-view.php";
                    }
                });
            });

            $("#cancel-btn").click(function () {

                window.location.href = "start-view.php";
            });
        });
    </script>
    </body>

    </html>

    <?php
} else {
    echo 'Image not found.';
}
?>
