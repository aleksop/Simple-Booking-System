<?php
session_start();
$userData = [];
if (isset($_SESSION['userId'])) {
    require_once  '../classes/dbh.classes.php';
    require_once  '../classes/users.classes.php';
  
    $User = new Users();
    $userData = $User->getUserById($_SESSION['userId']);
    echo json_encode($userData);
}
?>