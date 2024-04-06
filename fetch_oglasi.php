<?php
include "conn/connection.php";
// oglasi pri lodovanju
$query = "SELECT v.id, v.title, v.image_url, v.price, m.name AS manufacturer
          FROM vehicles v
          JOIN manufacturers m ON v.manufacturer_id = m.id";
$result = $con->query($query);


$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $imageURL = $row['image_url'];
        $price = $row['price'];
        $manufacturer = $row['manufacturer'];

        // Generate HTML for each vehicle
        $html .= '<div class="vehicle">';
        $html .= '<div class="image-wrapper" data-vehicle-id="' . $id . '">';
        $html .= '<img src="' . $imageURL . '" alt="' . $title . '">';
        $html .= '</div>';
        $html .= '<p>' . $title . '</p>';
        $html .= '<p>Manufacturer: ' . $manufacturer . '</p>';
        $html .= '<p>Price: ' . $price . '</p>';
        $html .= '</div>';
    }
}


echo $html;
?>
