<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    // echo "<script>userLoggedIn = '$userLoggedIn';</script>";
} else {
    header("Location: register.php");
}


$term = "";
if($_SERVER['REQUEST_URI'] == "search.php") {
    $term = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="assets/images/favicon/music-svgrepo-com.svg" type="image/x-icon">
    <title>Welcome to Aurora</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!-- <script src="assets/js/script.js"></script> -->

</head>

<body>
    <div class="main-content">
        <script>
            var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        </script>
        <?php include("side_bar.php") ?>

        <main>
            <header>
                <div class="nav-links">
                    <button class="menu-btn" id="menu-open">
                        <i class='bx bx-menu'></i>
                    </button>
                </div>

                <div class="search">
                    <i class='bx bx-search'></i>
                    <input type="text" class="searchInput"
                        value="<?php echo htmlspecialchars($term, ENT_QUOTES, 'UTF-8'); ?>"
                        placeholder="Type here to search" role='link' tabindex='0' onclick='openPage("search.php")'>
                </div>
            </header>
            <div class="container">