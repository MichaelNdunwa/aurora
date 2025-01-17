<?php
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");

$account = new Account($con);

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="assets/images/favicon/music-svgrepo-com.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Welcome to Vibeon</title>
</head>

<body>

    <div class="container" id="container">
        <!-- Register Form -->
        <div class="form-container sign-up">
            <form action="register.php" method="POST">
                <h1>Create Account</h1>
                <div class="input-field">
                    <input id="username" name="username" type="text" placeholder="Username" required>
                    <i class='bx bx-user'></i>
                </div>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <div class="input-field">
                    <input id="email" name="email" type="email" placeholder="Email" required>
                    <i class="bx bx-envelope"></i>
                </div>
                <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
                <div class="input-field">
                    <input id="password" name="password" type="password" placeholder="Password" required>
                    <i class="bx bx-lock"></i>
                </div>
                <?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
                <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                <?php echo $account->getError(Constants::$passwordCharacters); ?>
                <div class="input-field">
                    <input id="password2" name="password2" type="password" placeholder="Confirm Password" required>
                    <i class="bx bx-lock"></i>
                </div>
                <button type="submit" name="register-button">Sign Up</button>
                <span id="login-text">Already have an account? Signin here.</span>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container sign-in">
            <form action="register.php" method="POST">
                <h1>Sign In</h1>
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <div class="input-field">
                    <input id="loginUsername" name="login-username" type="text" placeholder="Username" value="<?php getInputValue('login-username') ?>" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input id="loginPassword" name="login-password" type="password" placeholder="Password" value="<?php getInputValue('login-username') ?>" required>
                <i class="bx bx-lock"></i>
                </div>
                <button type="submit" name="login-button">Sign In</button>
                <span id="register-text">Don't have an account yet? Signup here.</span>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to have access to none stop music on the go</p>
                    <button class="hidden" id="login-button">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hey, Awesome!</h1>
                    <p>Enter your personal details to have access to none stop music on the go</p>
                    <button class="hidden" id="register-button">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/register.js"></script>
</body>

</html>