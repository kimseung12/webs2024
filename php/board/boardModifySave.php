<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boardTitle = $_POST['boardTitle'];
    $boardContents = $_POST['boardContents'];
    $memberID = $_SESSION['memberID'];

    $boardTitle = $connect -> real_escape_string($boardTitle);
    $boardContents = $connect -> real_escape_string($boardContents);

    if (isset($_GET['boardID'])) {
        $boardID = $_GET['boardID'];
    
        // 게시물을 가져옵니다.
        $sql = "SELECT * FROM board WHERE boardID = $boardID";
        $result = $connect->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $boardTitle = $row['boardTitle'];
            $boardContents = $row['boardContents'];
    
            // 게시물 수정 폼을 생성합니다.
            echo "<form action='update.php' method='POST'>";
            echo "<input type='hidden' name='boardID' value='$boardID'>";
            echo "제목: <input type='text' name='boardTitle' value='$boardTitle'><br>";
            echo "내용: <textarea name='boardContents'>$boardContents</textarea><br>";
            echo "<input type='submit' value='수정'>";
            echo "</form>";
        } else {
            echo "게시물을 찾을 수 없습니다.";
        }
    } else {
        echo "게시물 ID가 전달되지 않았습니다.";
    }
    
    // 업데이트 후 게시판 페이지로 이동
    // echo "<script>window.location.href='board.php';</script>";
?>
