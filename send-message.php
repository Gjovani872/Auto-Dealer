<?php
include "conn/connection.php";
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect if user is not logged in
    header("Location: login-view.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $vehicleId = $_POST['vehicle_id'];
    $message = $_POST['message'];


    $insertQuery = "INSERT INTO messages (name, user_id, vehicle_id) VALUES (?, ?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("sii", $message, $userId, $vehicleId);
    if ($stmt->execute()) {
        echo "Message sent successfully.";
    } else {
        echo "Error sending message.";
    }
} else {
    echo "Invalid request.";
}
