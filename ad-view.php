<?php
include "conn/connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: views/login-view.php");
    exit();
}

if(isset($_GET['id'])){
    $imageId = $_GET['id'];
}else{
    $imageId = $_GET['vehicle_id'];
}

$query = "SELECT * FROM vehicles WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $imageId);
$stmt->execute();
$result = $stmt->get_result();

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
        <link rel="stylesheet" type="text/css" href="../style/ad.css">

        <script src="js/ad.js"></script>
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
                            <a class="dropdown-item" href="views/logout.php">Logout</a>
                            <a class="dropdown-item" href="views/add-view.php">Add</a>
                            <a class="dropdown-item" href="edit-view.php">Edit</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="image-wrapper">
                    <img src="<?php echo $imageURL; ?>" alt="<?php echo $title; ?>">
                </div>
            </div>
            <div class="col-md-6 image-details">
                <h2><?php echo $title; ?></h2>
                <p class="description"><?php echo "Description: " . $description; ?></p>
                <p><?php echo "Year: " . $year; ?></p>
                <p><?php echo "Mileage: " . $mileage; ?></p>
                <p class="price"><?php echo "Price: " . $price; ?></p>

                <?php
                if ($_SESSION['id'] == $userId || $_SESSION['username'] == 'admin') {
                    ?>
                    <div class="edit-delete-buttons">
                        <a class="btn btn-primary" href="edit_individual_ad.php?id=<?php echo $imageId; ?>">Edit</a>
                        <a class="btn btn-danger" href="delete-view.php?id=<?php echo $imageId; ?>">Delete</a>
                    </div>
                    <?php
                }
                ?>
                <div class="message-container">
                    <form id="message-form" >
                        <input type="hidden" id="user-id-hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
                        <input type="hidden" id="vehicle-id-hidden" name="vehicle_id" value="<?php echo $imageId; ?>">
                        <input type="text" id="message" name="message" placeholder="Type your message here">
                        <button type="submit" onclick="fetch_messages()">Send Message</button>
                    </form>
                    <table id="message-table">
                        <tr>
                            <th>Username</th>
                            <th>Message</th>
                        </tr>
                        <?php
                        $messageSQL = "SELECT messages.name, u.username FROM messages
                    INNER JOIN users u ON u.id = messages.user_id
                    INNER JOIN vehicles v ON v.id = messages.vehicle_id
                    WHERE messages.vehicle_id = '$imageId'";
                        $messageResult = $con->query($messageSQL);

                        if ($messageResult->num_rows > 0) {
                            while ($messageRow = $messageResult->fetch_assoc()) {
                                $username = $messageRow['username'];
                                $message = $messageRow['name'];


                                echo '<tr>';
                                echo '<td>' . $username . '</td>';
                                echo '<td>' . $message . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>

    </html>

    <?php
} else {
    echo 'Invalid image.';
}
