<?php
    ob_start();
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $mysql_hostname = "sql8.freemysqlhosting.net";
    $mysql_username = "sql8756176";
    $mysql_password = "byqwZGa8Qw";
    $mysql_db_name = "sql8756176";
    $con = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_db_name);

    // $mysql_hostname = "localhost";
    // $mysql_username = "root";
    // $mysql_password = "";
    // $mysql_db_name = "music_db";
    // $con = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_db_name);
    if (mysqli_connect_errno()) {
         echo "Failed to connect: " . mysqli_connect_errno();
    }
?>

