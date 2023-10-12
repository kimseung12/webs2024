<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글쓰기 저장</title>
</head>
<body>
<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boardTitle = $_POST['boardTitle'];
    $boardContents = $_POST['boardContents'];
    $boardView = 1;
    $regTime = time();
    $memberID = $_SESSION['memberID'];

    // echo $boardTitle, $boardContents, $memberID;
    
    // 세션을 통해 사용자가 로그인이 되어 있는지 확인
    if (!isset($_SESSION['memberID'])) {
        // 사용자가 로그인되지 않은 경우, 로그인 페이지로 리디렉션 또는 에러 메시지를 표시할 수 있습니다.
        // 예: header("Location: login.php");
        // 또는 에러 메시지를 출력하고 페이지를 중지시킬 수 있습니다.
        echo "<script>alert('로그인 후에 게시글을 작성할 수 있습니다.')</script>";
        echo "<script>window.history.back()</script>";
    } else {
        // 데이터 입력 여부
        if(empty($boardTitle) || empty($boardContents)){
            echo "<script>alert('제목또는 게시글을 작성해주세요!.')</script>";
            echo "<script>window.history.back()</script>";
        } else {
            $boardTitle = $connect -> real_escape_string($boardTitle);
            $boardContents = $connect -> real_escape_string($boardContents);
            $sql = "INSERT INTO board(memberID, boardTitle, boardContents, boardView, regTime) VALUES('$memberID', '$boardTitle', '$boardContents', '$boardView', '$regTime')";

            $connect -> query($sql);
            // if ($connect->query($sql)) {
                // 글 작성이 성공한 경우 메시지를 표시하고 board.php로 리디렉션합니다.
                echo "<script>alert('게시글이 성공적으로 작성되었습니다.')</script>";
                echo '<script>window.location.href = "board.php";</script>';
        }
        
    } 
?>
</body>
</html>