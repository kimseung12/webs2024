<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boradTitle = $_POST['boradTitle'];
    $boardContents = $_POST['boardContents'];
    $boardView = 1;
    $regTime = time();
    $memberID = $_SESSION['memberID'];

    // echo $boradTitle, $boardContents, $memberID;

    $boradTitle = $connect -> real_escape_string($boradTitle);
    $boardContents = $connect -> real_escape_string($boardContents);

    $sql = "INSERT INTO board(memberID, boradTitle, boardContents, boardView, regTime) VALUES('$memberID', '$boradTitle', '$boardContents', '$boardView', '$regTime')";

    $connect -> query($sql);
?>