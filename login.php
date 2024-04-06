<?php
require 'conn/connection.php';
// Start the session
session_start();

if(isset($_SESSION['username'])){
    header("Location:/zavrsniRedovniProjekat/start-view.php");
}

// uzmi od ajaxa
$username = $_POST['username'];
$password = $_POST['password'];


$errors = array(); //  niz za greske

// Provjera za svaki slucaj
if (strlen($username) < 3) {
    $errors[] = "Username must be at least 3 characters long";
}

if (strlen($password) < 3) {
    $errors[] = "Password must be at least 6 characters long";
}

if (count($errors) > 0) {
    // Ako postoje greške, vratite poruku o grešci na klijentsku stranu
    echo json_encode(array('status' => 'error', 'errors' => $errors));
    exit();
}



$sql = $con->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();

$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        // Sve je u redu , stavljamu username sesiju sa imenom na db
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['id'];
        echo json_encode(array('status' => 'success'));
    } else {
        //Password nije unijet kako treba
        echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password'));
    }
} else {
    // Korisnik nije nadjen
    echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password'));
}
?>
