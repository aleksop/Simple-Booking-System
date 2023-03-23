<?php

class ProfileController extends Users
{

    function __construct(private $user = "", private $email = "", private $phone = "", private $address = "", private $name = "")
    {
        parent::__construct();
    }
    public function update()
    {

        if ($this->emptyInput() == true) {
            header("Location: ../profile.php?error=emptyfields&user=" . $this->user . "&email=" . $this->email . "&phone=" . $this->phone . "&name=" . $this->name . "&address=" . $this->address);
            exit();
        } elseif ($this->invalidUser() == true) {
            header("Location: ../profile.php?error=invaliduser&email=" . $this->email . "&phone=" . $this->phone . "&name=" . $this->name . "&address=" . $this->address);
            exit();
        } elseif ($this->invalidEmail() == true) {
            header("Location: ../profile.php?error=invalidemail&user=" . $this->user . "&phone=" . $this->phone . $this->name . "&address=" . $this->address);
            exit();
        }

        $this->updateProfile($this->user, $this->email, $this->phone, $this->address, $this->name);
    }
    private function emptyInput()
    {
        $result = false;

        if (empty($this->user) || empty($this->email) || empty($this->phone) || empty($this->address) || empty($this->name)) {
            $result = true;
        }
        return $result;
    }
    private function invalidUser()
    {
        $result = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->user)) {
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
}
