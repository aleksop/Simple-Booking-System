<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once  '../classes/dbh.classes.php';
    require_once  '../classes/users.classes.php';
    require_once  '../classes/signup-controller.classes.php';

    $user = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST["phone"], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST["address"], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
    $pwdRepeat = htmlspecialchars($_POST["pwd2"], ENT_QUOTES, 'UTF-8');

    $signup = new SignupController($user, $email, $phone, $address, $name, $pwd, $pwdRepeat);
    $signup->register();

    header("Location: ../signup.php?signup=success");
    exit();
} else {
    header("Location: ../signup.php");
    exit();
}
