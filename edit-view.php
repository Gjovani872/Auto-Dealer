<?php
include "conn/connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login-view.php");
}

$loggedInUserId = "";
if (isset($_SESSION['id'])) {
    $loggedInUserId = $_SESSION['id'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/editview.css">
    <title>Oglasi</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="start-view.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['username'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        <a class="dropdown-item" href="edit-view.php">Edit</a>
                        <a class="dropdown-item" href="views/add-view.php">Add</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="content">
    <h1>Welcome to My Website</h1>
    <div class="oglasi"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        // prikaz vozila
        function fetchVehicles() {
            $.ajax({
                url: '/zavrsniRedovniProjekat/fetch_oglasi_for_certain_user.php',
                type: 'GET',
                success: function (response) {
                    $('.oglasi').html(response);

                    // Click event za svaku sliku
                    $('.image-wrapper').click(function () {
                        var vehicleId = $(this).data('vehicle-id');

                        // Otvori ad-view stranicu i prenesi vehicleId
                        var url = 'ad-view.php?id=' + vehicleId;
                        window.location.href = url;
                    });


                    var loggedInUserId = "<?php echo $loggedInUserId; ?>";
                    $('.image-wrapper').each(function () {
                        var ownerId = $(this).data('owner-id');
                        if (ownerId === loggedInUserId) {
                            $(this).find('.edit-delete-buttons').show();
                        } else {
                            $(this).find('.edit-delete-buttons').hide();
                        }
                    });


                    $('.edit-button').click(function () {
                        var vehicleId = $(this).data('vehicle-id');


                        var url = 'edit_individual_ad.php?id=' + vehicleId;
                        window.location.href = url;
                    });


                }
            });
        }

        // fetchuj
        fetchVehicles();
    });
</script>

</body>

</html>
