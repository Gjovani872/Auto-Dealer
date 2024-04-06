<?php

session_start();
session_unset();
session_destroy();
header("Location:/zavrsniRedovniProjekat/views/login-view.php");