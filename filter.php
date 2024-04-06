<?php
include "conn/connection.php";



$manufacturerID = $_GET['manufacturer'];
$vehicleCategoryID = $_GET['vehicle_category'];
//echo "<script>alert($vehicleCategoryID)</script>";


$query = "SELECT v.id, v.title, v.image_url, m.name AS manufacturer_name, u.username AS user_name, f.name AS fuel_type_name
          FROM vehicles v
          INNER JOIN manufacturers m ON v.manufacturer_id = m.id
          INNER JOIN users u ON v.user_id = u.id
          INNER JOIN fuel_types f ON v.fuel_type_id = f.id
          WHERE 1=1";

if (!empty($_GET['manufacturer'])) {
    $manufacturer = $_GET['manufacturer'];
    $query .= " AND m.name = '$manufacturer'";
}




$result = $con->query($query);

// Unesi html kod za ovo
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $imageURL = $row['image_url'];
        $manufacturerName = $row['manufacturer_name'];
        $userName = $row['user_name'];
        $fuelTypeName = $row['fuel_type_name'];

        $imagePath = 'images_uploads/';

        echo '<div class="vehicle">';
        echo '<a href="ad-view.php?id=' . $id . '">'; // link u ad.php i prenesi id
        echo '<div class="image-wrapper" data-vehicle-id="' . $id . '"><img src="' . $imageURL . '" alt="' . $title . '"></div>';
        echo '</a>';
        echo '<p>' . $title . '</p>';
        echo '<p>Manufacturer: ' . $manufacturerName . '</p>';
        echo '<p>User: ' . $userName . '</p>';
        echo '<p>Fuel Type: ' . $fuelTypeName . '</p>';
        echo '</div>';
    }
} else {
    echo 'No vehicles found.';
}
?>
