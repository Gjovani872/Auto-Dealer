<?php
include "conn/connection.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login-view.php");
}

$loggedInUserId = ""; // id logovanog usera
if (isset($_SESSION['id'])) {
    $loggedInUserId = $_SESSION['id'];
}

// uzmi vehicle id od url
if (!isset($_GET['id'])) {
    echo "Invalid vehicle ID.";
    exit();
}
$id = $_GET['id'];

// uzmi detlajne za vehicles
$query = "SELECT * FROM vehicles WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$con->close();

if (!$row) {
    echo "Vehicle not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/editindividualad.css">
    <title>Edit Vehicle</title>
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
                        <a class="dropdown-item" href="#">Logout</a>
                        <a class="dropdown-item" href="edit-view.php">Edit</a>
                        <a class="dropdown-item" href="views/add-view.php">Add</a>

                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<h1>Edit Vehicle</h1>
<form id="edit-form">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>">
    </div>
    <div>
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" value="<?php echo $row['year']; ?>">
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $row['price']; ?>">
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo $row['description']; ?></textarea>
    </div>
    <div>
        <input type="submit" value="Update">
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#edit-form').submit(function(e) {
            e.preventDefault();

            var year = $('#year').val();
            var price = $('#price').val();
            var description = $('#description').val();
            var title = $('#title').val();

            $.ajax({
                type: 'POST',
                url: 'update-ad.php',
                data: {
                    id: <?php echo $id; ?>,
                    year: year,
                    price: price,
                    description: description,
                    title: title
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert(data.message);

                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });
</script>
</body>

</html>
