<?php

require 'conn/connection.php';
session_start();

// Uzmi value iz posta , (gdje smo definisali na ajax type)
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if(empty($username) || strlen($username) < 4 || strlen($password) < 6){
    echo "error";
    exit();
}

// Gledamo da li username postoji u db
$checkQuery = "SELECT * FROM users WHERE username = ?";
$stmt = $con->prepare($checkQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$checkResult = $stmt->get_result();

if ($checkResult->num_rows > 0) {
    // Korisnik vec postoji
    echo "user_exists";
} else {
    // Korisnik ne postoji nastavi sa registracijom

    // Ako se passwordi slazu kondicija
    if ($password !== $confirmPassword) {
        // Passwordi se ne slazu , prekini dalje izvrsenje
        echo "Passwords do not match";
        exit();
    }

    // Hesujemo password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Unos korisnika
    $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $con->prepare($insertQuery);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        // Registracija uspj
        echo "success";
    } else {
        // Reg. neuspj.
        echo "An error occurred during registration.";
    }
}

// Zatvori bazu
$con->close();

?>
