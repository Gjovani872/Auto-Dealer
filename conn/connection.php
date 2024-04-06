<?php
$localhost = 'localhost';
$user = 'root';
$pass = 'password';
$database = 'autooglas2';
$port = 3306;

$con = new mysqli($localhost, $user, $pass, $database, $port);

if ($con->connect_error) {
    die("Connection not made: " . $con->connect_error);
}
