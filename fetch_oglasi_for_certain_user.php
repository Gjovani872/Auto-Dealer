<?php
include "conn/connection.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login-view.php");
}
// logovani user
$loggedInUserId = $_SESSION['id'];

// fetch vehicles za logovanog korisnika
if($_SESSION['username'] == 'admin'){
    $query = "SELECT v.id, v.title, v.image_url, v.price, m.name AS manufacturer
          FROM vehicles v
          JOIN manufacturers m ON v.manufacturer_id = m.id";
}else{
    $query = "SELECT v.id, v.title, v.image_url, v.price, m.name AS manufacturer
          FROM vehicles v 
          JOIN manufacturers m ON v.manufacturer_id = m.id
          WHERE v.user_id = $loggedInUserId";
}

$result = $con->query($query);


$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $imageURL = $row['image_url'];
        $price = $row['price'];
        $manufacturer = $row['manufacturer'];

        // Generacija html za svaki
        $html .= '<div class="vehicle">';
        $html .= '<div class="image-wrapper" data-vehicle-id="' . $id . '">';
        $html .= '<img src="' . $imageURL . '" alt="' . $title . '">';
        $html .= '</div>';
        $html .= '<p>' . $title . '</p>';
        $html .= '<p>Manufacturer: ' . $manufacturer . '</p>';
        $html .= '<p>Price: ' . $price . '</p>';
        $html .= '</div>';
    }
} else {
    $html = '<p>No vehicles found for the logged-in user.</p>';
}

// salaji html
echo $html;
?>
