<?php


class Users
{

    private $DB; // PDO connection
    public function __construct()
    {
        $this->DB = Dbh::getInstance();
    }

    // check username
    public function checkUserExists($user)

    {
        $this->DB->query("SELECT * FROM users WHERE `uid` = ?", [$user]);
        if ($this->DB->stmt->rowCount()) {
            return true;
        } else {
            return false;
        }          
    }
    // check email
    public function checkEmailExists($email)

    {
        $this->DB->query("SELECT * FROM users WHERE `email` = ?", [$email]);
        if ($this->DB->stmt->rowCount()) {
            return true;
        } else {
            return false;
        }       
    }
    // add user
    public function addUser($user, $email, $phone, $address, $pwd, $name, $admin = 0)
    {
        $sql = "INSERT INTO `users` (`uid`, `email`, `phone`, `address`, `password`, `name`, `admin`) VALUES (?,?,?,?,?,?,?)";
        $data = [$user, $email,  $phone, $address, $pwd, $name, $admin];
        $this->DB->query($sql, $data);
    }

    // update user info
    public function updateProfile($user, $email, $phone, $address, $name)
    {
        $sql = "UPDATE  `users` SET `email`=?, `phone`=?, `address`=?, `name`=? WHERE 'idUser'=?";
        $data = [$email,  $phone, $address, $name, $user];
        $this->DB->query($sql, $data);
    }
    // get credentials
    public function getUserByName($user)
    {
        $this->DB->query("SELECT * FROM `users` WHERE `uid`=?", [$user]);
        $users = [];
        while ($r = $this->DB->stmt->fetch()) {
            $users = array(
                "idUser" => $r["idUser"],
                "email" => $r["email"], "password" => $r["password"],
                "phone" => $r["phone"], "address" => $r["address"],
                "username" => $r["uid"], "name" => $r["name"]
            );
        }
        return count($users) == 0 ? false : $users;
    }
    // get credentials
    public function getUserById($userId)
    {
        $this->DB->query("SELECT * FROM `users` WHERE `idUser`=?", [$userId]);
        $users = [];
        while ($result = $this->DB->stmt->fetch()) {
            $users = array(
                "idUser" => $result["idUser"],
                "email" => $result["email"], "password" => $result["password"],
                "phone" => $result["phone"], "address" => $result["address"],
                "username" => $result["uid"], "name" => $result["name"], "admin" => $result["admin"]
            );
        }
        return count($users) == 0 ? false : $users;
    }
}
