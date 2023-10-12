<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    $searchKeyword = $_GET['searchKeyword'];
    $searchOption = $_GET['searchOption'];

    $searchKeyword = $connect -> real_escape_string(trim($searchKeyword));
    $searchOption = $connect -> real_escape_string(trim($searchOption));

    $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youName, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) ";
    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youName, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youName, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) WHERE b.boardContents LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youName, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";

    switch($searchOption){
        case "title":
            $sql .="WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
        case "contents":
            $sql .="WHERE b.boardContents LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
        case "name":
            $sql .="WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
    }
    $result = $connect -> query($sql);

    $totalCount = $result -> num_rows;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 블로그 만들기</title>

    <?php include "../include/head.php" ?>
</head>
<body class="gray">
    <?php include "../include/skip.php" ?>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main" role="main">
        <div class="intro__inner bmStyle container">
        <div class="intro__img small">
                <img srcset="../assets/img/intro03-min.jpg 1x, ../assets/img/intro03@2x-min.jpg 2x, ../assets/img/intro03@3x-min.jpg" alt="소개 이미지">
            </div>
            <div class="intro__text">
                <h2>결과 페이지</h2>
                <p>
                    웹디자이너, 웹 퍼블리셔, 프론트엔드 개발자를 위한 게시판입니다.<br>
                    총 <em><?=$totalCount?></em>건의 게시물이 검색되었습니다.
                </p>
            </div>
        </div>
        <section class="board__inner container">
            <div class="board__table">
                <table>
                    <colgroup>
                        <col style="width: 5%;">
                        <col style="width: 63%;">
                        <col style="width: 10%;">
                        <col style="width: 15%;">
                        <col style="width: 7%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>등록자</th>
                            <th>등록일</th>
                            <th>조회수</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;

    $sql .=" LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if($result){
        $Count = $result -> num_rows;

        if($Count > 0){
            for($i=0; $i<$Count; $i++){
                $info = $result -> fetch_array(MYSQLI_ASSOC);

                echo "<tr>";
                echo "<td>".$info['boardID']."</td>";
                echo "<td><a href='boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</a></td>";
                echo "<td>".$info['youName']."</td>";
                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                echo "<td>".$info['boardView']."</td>";
                echo "</tr>";
                
            }
        } else {
            echo "<tr><td colspan='5'>게시글이 없습니다.</td></tr>";
        }
    } else {
        echo "관리자에게 문의해주세요!!";
    }
?>
                    </tbody>
                </table>
            </div>
            <!-- board__table -->

            <div class="board__pages">
                <ul>
<?php
    // 총 페이지 갯수
    $boardTotalCount = ceil($totalCount/$viewNum); //29.4이면 --> 30페이지로 올림

    // 1 2 3 4 5 6 [7] 8 9 10 11 12
    $pageView = 5;
    $startPage = $page - $pageView;
    $endPage = $page + $pageView;
    // 이전 페이지 및 다음 페이지 계산
    $prevPage = ($page > 1) ? $page - 1 : 1;
    $nextPage = ($page < $boardTotalCount) ? $page + 1 : $boardTotalCount;

    // 처음 페이지 초기화 / 마지막 페이지 초기화
    if($startPage < 1) $startPage = 1;
    if($endPage >= $boardTotalCount) $endPage = $boardTotalCount;

    // 처음으로/이전
    if ($totalCount > 0) {
        if($page !=1){
            $prevPage = $page - 1;
            echo "<li class='first'><a href='boardSearch.php?page=1&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>처음으로</a></li>";
            echo "<li class='prev'><a href='boardSearch.php?page={$prevPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>이전</a></li>";
        }

        // 페이지
        for($i=$startPage; $i<=$endPage; $i++){
            $active = "";
            if($i == $page) $active = "active";

            echo "<li class='{$active}'><a href='boardSearch.php?page={$i}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>${i}</a></li>";
        }
    
        // 마지막으로/다음
        if($page != $boardTotalCount){
            $nextPage = $page + 1;
            echo "<li class='next'><a href='boardSearch.php?page={$nextPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>다음</a></li>";
            echo "<li class='last'><a href='boardSearch.php?page={$boardTotalCount}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>마지막으로</a></li>";
        }
    }
?>
                </ul>
            </div>
        </section>
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>
</html>
