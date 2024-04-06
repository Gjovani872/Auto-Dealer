<?php
include "conn/connection.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location:login-view.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $manufacturer = $_POST["manufacturer"];
    $category = $_POST["category"];
    $fuelType = $_POST["fuel_type"];
    $mileage = $_POST["mileage"];
    $year = $_POST["year"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    if (!is_numeric($year) || intval($year) <= 0) {
        $errors["year"] = "Invalid year entered.";
    }

    // Validate mileage
    if (empty($mileage) || !is_numeric($mileage) || intval($mileage) < 0) {
        $errors["mileage"] = "Invalid mileage entered.";
    }

    // Validate price
    if (empty($price) || !is_numeric($price) || floatval($price) < 0) {
        $errors["price"] = "Invalid price entered.";
    }

    // Check if any errors occurred
    if (!empty($errors)) {
        echo json_encode(["success" => false, "errors" => $errors]);
        exit;
    }

    $manufacturerId = getManufacturerIdByName($manufacturer);
    $categoryId = getCategoryIdByName($category);
    $fuelTypeId = getFuelTypeIdByName($fuelType);


    if (!$manufacturerId) {
        echo json_encode(["success" => false, "message" => "Invalid manufacturer selected."]);
        exit;
    }

    if (!$categoryId) {
        echo json_encode(["success" => false, "message" => "Invalid category selected."]);
        exit;
    }

    if (!$fuelTypeId) {
        echo json_encode(["success" => false, "message" => "Invalid fuel type selected."]);
        exit;
    }

    $imagePath = "";
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $tempName = $_FILES["image"]["tmp_name"];
        $fileName = $_FILES["image"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $imagePath = "images_uploads2/" . uniqid() . "." . $ext;

        if (!move_uploaded_file($tempName, $imagePath)) {
            echo json_encode(["success" => false, "message" => "Error uploading the image."]);
            exit;
        }
    }

    $query = "INSERT INTO vehicles (user_id, manufacturer_id, category_id, fuel_type_id, title, mileage, year, price, image_url, description) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiissiisss", $userId, $manufacturerId, $categoryId, $fuelTypeId, $title, $mileage, $year, $price, $imagePath, $description);
    $userId = $_SESSION['id']; // Set the user ID here
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Ad added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error adding the ad."]);
    }
}

function getManufacturerIdByName($name) {
    global $con;
    $query = "SELECT id FROM manufacturers WHERE name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return $id;
}

function getCategoryIdByName($name) {
    global $con;
    $query = "SELECT id FROM vehicle_categories WHERE name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return $id;
}

function getFuelTypeIdByName($name) {
    global $con;
    $query = "SELECT id FROM fuel_types WHERE name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->fetch();
    $stmt->close();
    return $id;
}
?>

