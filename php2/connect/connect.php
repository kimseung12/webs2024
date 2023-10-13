<?php
    $host = "localhost";
    $user = "tmddn113";
    $pw = "tmddnrla1!";
    $db = "tmddn113";

    $connect = new mysqli($host, $user, $pw, $db);
    $connect -> set_charset("utf-8");

    // if(mysqli_connect_errno()){
    //     echo "DATABASE Connect False";
    // } else {
    //     echo "DATABASE Connect True";
    // }
?>