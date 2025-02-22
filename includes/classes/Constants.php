<?php
    class Constants {
        // Register error message:
        public static $passwordsDoNoMatch = "Your passwords don't match";
        public static $passwordNotAlphanumeric = "Your password can only contain numbers and letters";
        public static $passwordCharacters = "Your password must be between 5 and 25 characters";
        public static $emailInvalid = "Email is invalid";
        public static $emailsDoNotMatch = "Your emails don't match";
        public static $emailTaken = "This email is already in use";
        public static $lastNameCharacters = "Your username must be between 2 and 25 characters";
        public static $firstNameCharacters = "Your first name must be between 2 and 25 characters";
        public static $usernameCharacters = "Your username must be between 3 and 25 characters";
        public static $usernameTaken = "This username already exist";
        
        // Login error message:
        public static $loginFailed = "Your username or password was incorrect";
        
    }
?>