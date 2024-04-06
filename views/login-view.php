<?php
session_start();

if(isset($_SESSION['username'])){
    header("Location: /zavrsniRedovniProjekat/start-view.php");
    return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../style/login.css">
    <script src="../js/login.js"></script>
</head>

<body class="bg-dark">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center text-dark mb-4">Login</h2>
            <form id="login-form" onsubmit="event.preventDefault(); loginVerification();">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" id="username" type="text" placeholder="Enter your username" oninput="checkLogin()">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" type="password" placeholder="Enter your password" oninput="checkLogin()">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" id="login-button" type="submit"  onclick="loginVerification()" disabled>Sign In</button>
                </div>
                <p id="message" class="text-center text-danger"></p>
            </form>
            <p class="text-center text-muted">No account? <a href="registration-view.php">Register</a></p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>