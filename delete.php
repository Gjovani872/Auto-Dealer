<?php
include "conn/connection.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login-view.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageId = $_POST['id'];


    $query = "DELETE FROM vehicles WHERE id = $imageId";
    if ($con->query($query)) {

        echo json_encode(['status' => 'success', 'message' => 'Ad deleted successfully.']);
    } else {

        echo json_encode(['status' => 'error', 'message' => 'Failed to delete the ad.']);
    }
} else {

    header("HTTP/1.1 400 Bad Request");
    exit();
}
?>

