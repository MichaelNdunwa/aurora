<?php 
if (isset($_POST["login-button"])) {
    // Login button was pressed:
    $username = $_POST['login-username'];
    $password = $_POST['login-password'];

    // Login function
    $result = $account->login($username, $password);
    if ($result == true) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
        // header("Location: music.php");
        // header("Location: https://open.spotify.com/");
    }
}
?>