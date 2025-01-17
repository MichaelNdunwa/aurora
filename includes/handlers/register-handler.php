<?php
function sanitizeFormPassword($inputText) {
    $inputText = strip_tags($inputText);
    return $inputText;
}
function sanitizeFormUsername($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","", $inputText);
    return $inputText;
}
function sanitizeFormString($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ","", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}



if (isset($_POST["register-button"])) {
    // Register button was pressed:
    $username = sanitizeFormUsername($_POST["username"]);
    $email = sanitizeFormString($_POST["email"]);
    $password = sanitizeFormPassword($_POST["password"]);
    $password2 = sanitizeFormPassword($_POST["password2"]);
    
    $wasSuccessful = $account->register($username, $email, $password, $password2);
    
    if ($wasSuccessful == true) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
        // header("Location: music.php");
    }
}
?>