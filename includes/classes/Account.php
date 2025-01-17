<?php
class Account
{
    private $con;
    private $errorArray;
    private $web_name = "aurora";
    public function __construct($con)
    {
        $this->con = $con;
        $this->errorArray = array();
    }

    // public function login($un, $pw)
    // {
    //     $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
    //     $query = mysqli_query($this->con, "SELECT  * FROM users WHERE username='$un' AND password='$hashedPw' AND website='$this->web_name'");
    //     if (mysqli_num_rows($query) == 1) {
    //         $user = mysqli_fetch_array($query);
    //         if (password_verify($pw, $user['password'])) {
    //             return true;
    //         }
    //     }
    //     array_push($this->errorArray, Constants::$loginFailed);
    //     return false;
    // }
    public function login($un, $pw) {
    $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND website='$this->web_name'");
    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_array($query);
        if (password_verify($pw, $user['password'])) {
            return true;
        }
    }
    array_push($this->errorArray, Constants::$loginFailed);
    return false;
}
    public function register($un, $em, $pw, $pw2)
    {
        // Validate credentials:
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePassword($pw, $pw2);

        if (empty($this->errorArray) == true) {
            // insert into db:
            return $this->insertUserDetails($un, $em, $pw);
        } else {
            return false;
        }
    }
    public function getError($error)
    {
        if (!in_array($error, $this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    // Insert user deatils to mysql db:
    private function insertUserDetails($un, $em, $pw)
    {
        $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
        $profilePic = "assets/images/profile-pics/michael.jpg";
        $date = date("Y-m-d H:i:s");
        $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$em', '$hashedPw', '$date', '$profilePic', '$this->web_name')");
        return $result;
    }
    private function validateUsername($un)
    {
        if (strlen($un) > 25 || strlen($un) < 3) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }
        $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
        if (mysqli_num_rows($checkUsernameQuery) != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
            return;
        }
    }

    private function validateEmail($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
        if (mysqli_num_rows($checkEmailQuery) != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
            return;
        }
    }

    private function validatePassword($pw, $pw2)
    {
        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNoMatch);
            return;
        }
        if (preg_match('/[^A-Za-z0-9]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }
        if (strlen($pw) > 25 || strlen($pw) < 5) {
            array_push($this->errorArray, Constants::$passwordCharacters);
            return;
        }
    }
}
?>