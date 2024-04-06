<?php

if(isset($_SESSION['username'])){
    header("Location:/zavrsniRedovniProjekat/start-view.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/register.css">
    <script src="../js/register.js"></script>
    <link rel="icon" href="data:,">
    <style>
        body {
            background-color: #000;
        }
    </style>
    <title>Registration Page</title>
</head>

<body class="flex items-center justify-center h-screen bg-dark">
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center text-dark mb-4">Registration</h2>
            <form id="registration-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" type="text" placeholder="Enter your username" oninput="check()">
                    <p id="username-error" class="text-danger"></p>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" placeholder="Enter your password" oninput="check()">
                    <p id="password-error" class="text-danger"></p>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input class="form-control" id="confirm-password" type="password" placeholder="Confirm your password" oninput="check()">
                    <p id="confirm-password-error" class="text-danger"></p>
                    <p id="user-exists-error" class="text-danger"></p>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" id="register-button" type="submit" onclick="register()" disabled>Register</button>
                </div>
            </form>
            <p class="text-center text-muted">Go to login <a href="/zavrsniRedovniProjekat/views/login-view.php">Login</a></p>
            <p id="message" class="text-danger"></p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
