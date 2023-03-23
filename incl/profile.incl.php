<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once  '../classes/dbh.classes.php';
    require_once  '../classes/users.classes.php';
    require_once  '../classes/profile-controller.classes.php';

    if (isset($_SESSION['userId']) ) {
        $user = htmlspecialchars($_POST["userId"], ENT_QUOTES, 'UTF-8');
        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
        $phone = htmlspecialchars($_POST["phone"], ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($_POST["address"], ENT_QUOTES, 'UTF-8');   
        $profile = new ProfileController($user, $email, $phone, $address, $name);
        $profile->update();
        header("Location: ../profile.php?update=success");
        exit(); 
    }
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
