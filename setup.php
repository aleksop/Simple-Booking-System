<!DOCTYPE html>
<html>

<head>
  <title>Setting up database</title>
</head>

<body>
  <h3>Setting up...</h3>

  <?php
  $admin = "admin";
  $pwdAdmin = "1234";

  require_once  'classes/dbh.classes.php';
  require_once  'classes/users.classes.php';
  require_once  'classes/signup-controller.classes.php';

  $connection = Dbh::getInstance();

  $sql = "CREATE TABLE IF NOT EXISTS `events` (
  `evt_id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `evt_date` date NOT NULL,
  `evt_time` time NOT NULL,
  `evt_text` text NOT NULL,
  `evt_color` varchar(7) NOT NULL,
  `evt_bg` varchar(7) NOT NULL,
  `evt_phone` varchar(20) NOT NULL,
  `userId` int(11) NOT NULL,
  INDEX(evt_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

  $connection->query($sql);
  echo "Table `events` created or already exists.<br>";

  $sql = "CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp(), 
  INDEX(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci; ";
  $connection->query($sql);
  echo "Table `reviews` created or already exists.<br>";

  $sql = "CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `uid` tinytext NOT NULL ,
  `email` tinytext NOT NULL,
  `phone` tinytext DEFAULT NULL,
  `address` tinytext DEFAULT NULL,
  `password` longtext NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `name` tinytext DEFAULT NULL,
  INDEX(idUser),
  INDEX(uid) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
  $connection->query($sql);
  echo "Table `reviews` created or already exists.<br>";


  $signup = new SignupController("admin", "", "", "", "admin", "1234", "1234");

  if ($signup->checkUserExists($admin)) {
    echo "User $admin already exists";
  } else {
    $signup->addUser("admin", "", "", "", password_hash($pwdAdmin, PASSWORD_DEFAULT), "admin", true);
    echo "User `admin` created.<br>";
  }

  ?>

  <br>...done.
</body>

</html>