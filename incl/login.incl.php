<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once  '../classes/dbh.classes.php';
    require_once  '../classes/users.classes.php';
    $Users = new Users();
    $user = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
    if (empty($user) || empty($pwd)) {
        header("Location: ../login.php?error=emptyfields");
        exit();
    }
    $userData = $Users->getUserByName($user);
    if (!$userData) {
        header("Location: ../login.php?error=notexists");
        exit();
    }
    $pwdCheck = password_verify($pwd, $userData['password']);
    if ($pwdCheck == false) {
        header("Location: ../login.php?error=wrongpassword");
        exit();
    } else {
        session_start();
        $_SESSION['userId'] =  $userData['idUser'];
        $_SESSION['userName'] =  $userData['username'];
        header("Location: ../index.php?login=success");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
