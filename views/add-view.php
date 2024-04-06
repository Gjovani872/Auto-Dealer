<?php
session_start();
include "../conn/connection.php";
if(!isset($_SESSION['username'])){
    header("Location:login-view.php");
}
?>

<!doctype html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/add.css">
    <title>Add an Ad</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="../start-view.php"><h4 id="website-logo">Home</h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                <?php echo $_SESSION['username']; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="logout.php">Logout</a>
                <a class="dropdown-item" href="../edit-view.php">Edit</a>
            </div>
        </div>
    </div>
</nav>



<div class="container">
    <h2>Add an Ad</h2>
    <form id="addForm" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br><br>

        <label for="manufacturer">Manufacturer:</label>
        <select name="manufacturer" required>
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
        </select><br><br>

        <label for="category">Category:</label>
        <select name="category" required>
            <?php
            $categorySQL = "SELECT name FROM vehicle_categories GROUP BY name;";
            $checkResult = $con->query($categorySQL);

            if ($checkResult->num_rows > 0) {
                while ($row = $checkResult->fetch_assoc()) {
                    $name = $row['name'];
                    echo "<option value='$name'>$name</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="fuelType">Fuel Type:</label>
        <select name="fuel_type" required>
            <?php
            $fuelTypeSQL = "SELECT name FROM fuel_types GROUP BY name;";
            $checkResult = $con->query($fuelTypeSQL);

            if ($checkResult->num_rows > 0) {
                while ($row = $checkResult->fetch_assoc()) {
                    $name = $row['name'];
                    echo "<option value='$name'>$name</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" required><br><br>

        <label for="year">Year:</label>
        <input type="text" name="year" required><br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" required><br><br>

        <label for="image">Select Picture:</label>
        <input type="file" name="image" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" rows="5"></textarea><br><br>

        <div class="button-container">
            <button type="submit">Add</button>
        </div>
    </form>
    <div id="status"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addForm').submit(function(e) {
            e.preventDefault();
            var serverURL = '/zavrsniRedovniProjekat/'
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);

            $.ajax({
                type: 'POST',
                url: serverURL +'insert_check.php',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('#status').html('<p class="success">' + response.message + '</p>');
                        form.trigger('reset');
                    } else if (response.errors) {
                        var errorHtml = '<ul class="error">';
                        $.each(response.errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>';
                            $('#' + key).addClass('error-input');
                        });
                        errorHtml += '</ul>';
                        $('#status').html(errorHtml);
                    } else {
                        $('#status').html('<p class="error">' + response.message + '</p>');
                    }
                },
                error: function() {
                    $('#status').html('<p class="error">Error occurred. Please try again later.</p>');
                }
            });
        });
    });
</script>
</body>
</html>
