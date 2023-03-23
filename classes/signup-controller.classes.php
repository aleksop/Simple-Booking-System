<?php

class SignupController extends Users
{

    function __construct(private $user = "", private $email = "", private $phone = "", private $address = "", private $name = "", private $pwd = "", private $pwdRepeat = "")
    {
        parent::__construct();
    }
    public function register()
    {

        if ($this->emptyInput() == true) {
            header("Location: ../signup.php?error=emptyfields&user=" . $this->user . "&email=" . $this->email . "&phone=" . $this->phone);
            exit();
        } elseif ($this->invalidUser() == true) {
            header("Location: ../signup.php?error=invaliduser&email=" . $this->email . "&phone=" . $this->phone);
            exit();
        } elseif ($this->invalidEmail() == true) {
            header("Location: ../signup.php?error=invalidemail&user=" . $this->user . "&phone=" . $this->phone);
            exit();
        } elseif ($this->passwordsMatch() == false) {
            header("Location: ../signup.php?error=pwdcheck&user=" . $this->user . "&email=" . $this->email . "&phone=" . $this->phone);
            exit();
        }
        if ($this->checkUserExists($this->user) == true) {
            header("Location: ../signup.php?error=usertaken&user=" . $this->user . "&email=" . $this->email . "&phone=" . $this->phone);
            exit();
        }
        if ($this->checkEmailExists($this->email) == true) {
            header("Location: ../signup.php?error=emailtaken&user=" . $this->user . "&email=" . $this->email . "&phone=" . $this->phone);
            exit();
        }
        $hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);
        $this->addUser($this->user, $this->email, $this->phone, $this->address, $hashedPwd, $this->name);
    }
    private function emptyInput()
    {
        $result = false;
        if (empty($this->user) || empty($this->email) || empty($this->phone) || empty($this->pwd)) {
            $result = true;
        }
        return $result;
    }
    private function invalidUser()
    {
        $result = false;
        if (!preg_match("/^[@.a-zA-Z0-9]*$/", $this->user)) {
            $result = true;
        }
        return $result;
    }
    private function invalidEmail()
    {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        }
        return $result;
    }
    private function passwordsMatch()
    {
        $result = false;
        if ($this->pwd == $this->pwdRepeat) {
            $result = true;
        }
        return $result;
    }
}
