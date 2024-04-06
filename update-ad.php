<?php
include "conn/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // od forme koje smo preko ajaxa
    $id = $_POST['id'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $title = $_POST['title'];

    // Update the vehicle in the database
    $query = "UPDATE vehicles SET year = ?, price = ?, description = ?, title = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iisss", $year, $price, $description, $title, $id);
    $stmt->execute();


    if ($stmt->affected_rows > 0) {

        $response = array(
            'success' => true,
            'message' => 'Vehicle updated successfully.'
        );
        echo json_encode($response);
    } else {

        $response = array(
            'success' => false,
            'message' => 'Failed to update vehicle.'
        );
        echo json_encode($response);
    }


    $stmt->close();
    $con->close();
} else {
    echo "Invalid request.";
}
?>
