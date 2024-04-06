<?php
include "conn/connection.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location:/gjoviweb/zavrsniRedovniProjekat/views/login-view.php");
}



$loggedInUserId = "";
if (isset($_SESSION['id'])) {
    $loggedInUserId = $_SESSION['id']; //id logovanog korisnika
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/start.css">
    <title>Oglasi</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="start-view.php">Oglasi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['username']?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="edit-view.php">Edit</a>
                        <a class="dropdown-item" href="/zavrsniRedovniProjekat/views/add-view.php">Add</a>

                        <a class="dropdown-item" href="views/logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="pretraga">
    <form id="filterForm">
        <div class="row">
            <div class="col-sm-4 polja-pretrage-item">
                <label>Proizvođač:</label>
                <div class="select-dropdown-picker">
                    <select name="manufacturer">
                        <option value="">Izaberi</option>
                        <?php
                        $manufacturerSQL = "SELECT name FROM manufacturers GROUP BY name;";
                        $checkResult = $con->query($manufacturerSQL);

                        if ($checkResult->num_rows > 0) {
                            while ($row = $checkResult->fetch_assoc()) {
                                $name = $row['name'];
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 polja-pretrage-item">
                <label>Vrsta goriva:</label>
                <div class="select-dropdown-picker">
                    <select name="fuel_type">
                        <option value="">Izaberi</option>
                        <?php
                        $fuelSQL = "SELECT name FROM fuel_types GROUP BY name;";
                        $checkResult = $con->query($fuelSQL);

                        if ($checkResult->num_rows > 0) {
                            while ($row = $checkResult->fetch_assoc()) {
                                $name = $row['name'];
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 polja-pretrage-item">
                <label>Kategorija:</label>
                <div class="select-dropdown-picker">
                    <select name="vehicle_category">
                        <option value="">Izaberi</option>
                        <?php
                        $vehicleCategorySQL = "SELECT name FROM vehicle_categories GROUP BY name;";
                        $checkResult = $con->query($vehicleCategorySQL);

                        if ($checkResult->num_rows > 0) {
                            while ($row = $checkResult->fetch_assoc()) {
                                $name = $row['name'];
                                echo "<option value='$name'>$name</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Pretraga</button>
    </form>
</div>


<div class="content">
    <h1>Welcome to My Website</h1>
    <div class="oglasi"></div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>



<script>
    $(document).ready(function() {
        function fetchVehicles() {
            $.ajax({
                url: 'fetch_oglasi.php',
                type: 'GET',
                success: function(response) {
                    $('.oglasi').html(response);

                    // Unesi klik event u image weapper
                    $('.image-wrapper').click(function() {
                        var vehicleId = $(this).data('vehicle-id');

                        // Otvori  ad.php sa vehicle id u url
                        var url = 'ad-view.php?id=' + vehicleId;
                        window.location.href = url;
                    });



                }
            });
        }


        fetchVehicles();

       //event list za submisiju forme
        $('#filterForm').on('submit', function(event) {
            event.preventDefault(); // Prevencija da se submisije forma

            // Get form data
            var formData = $(this).serialize();

            // Filter request preko ajaxa
            $.ajax({
                url: 'filter.php',
                type: 'GET',
                data: formData,
                success: function(response) {
                    $('.oglasi').html(response);
                }
            });
        });
    });

</script>



</body>

</html>