<?php
    $hostname = "127.0.0.1";
    $usernane = "root";
    $password = "";
    $db = "hkvep";

    $conn = mysqli_connect($hostname, $usernane, $password, $db) or die(mysqli_connect_error());
    mysqli_set_charset($conn, "utf8");
?>