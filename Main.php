<?php
header('Content_Type: text/html; charset=UTF-8');
//include './WriteLog.php';
include './SQLconstants.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

// MySQL 드라이버 연결
$conn = mysqli_connect($mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database) or die ("Cannot access DB");
session_start();
$session_id = $_SESSION['session_id'];
if($session_id == NULL) {
	echo '<script>alert("세션 id 초기화");</script>';
	$session_id = session_id();
	$_SESSION['session_id'] = $session_id;
}
if($_SESSION['isLogin'] == true) {
	$login_text = 'My Page';
} else {
	$login_text = 'Sign in';
}
$message = "";

?>
<html>

<head>
<script type="text/javascript">
function showMessage(message) {
	if ((message != null) && (message != "") && (message.substring(0, 3) == " * ")) {
		alert(message);
	}
}
</script>
    <style>

    </style>
    <meta charset="utf-8" />
    <title>PC v0.1 - 메인 화면</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onLoad="showMessage( '<?php echo $_POST['message'];?>' );">
    <!--메뉴바-->
    <nav class="menubar">
	<ul class="menu">
	    <li><a href="Main.php">
		    <h1 class="logo">Pet Care</h1>
		</a></li>
	    <li style="margin-left: 450px;">
		<h1 class="logo">Main</a>
	    </li>
	</ul>
	<ul class="mydata">
	    <!--<li><a href="add.php">맛집 추가</a></li>
	    <li><a href="delete.php">맛집 삭제</a></li>-->
	    <li><a href="login.php"><?=$login_text?></a></li>
	</ul>
    </nav>

    <!--검색창-->
    <section>
	<div id="searchbox">
	    <h2>What does my pet need?</h2>
	    <form name="formm" method="post">
		<input type="text" id="search" name="searchquery" value="<?php echo $_POST['searchquery'];?>" placeholder="Search...">
		<input type="image" id="searchicon" style="position: relative; width: 30px; height: 30px; top: 10px;" src="image/search_icon.png" alt="검색버튼">
	    </form>
	</div>
    </section>

    <!--맛집 나열창-->
    <section>
	<div id="storebox">
	    <div id="categorybox">
		<br>
		<form action="Main.php" method="POST">
		    <button id="category_img" type="submit" name="category" value="food"><img src="image/category/category_food.png" alt="food" width="100" height="100">
		    <button id="category_img" type="submit" name="category" value="snack"><img src="image/category/category_snack.png" alt="snack" width="100" height="100">
		    <button id="category_img" type="submit" name="category" value="supply"><img src="image/category/category_supply.png" alt="supply" width="100" height="100">
		    <button id="category_img" type="submit" name="category" value="kit"><img src="image/category/category_testKit.png" alt="test kits" width="100" height="100">
		</form>
		<br>
	    </div>
<?php

// 전달 받은 메시지 확인
$message = $_POST['message'];
$category = $_POST['category'];
$keyword = $_POST['searchquery'];
$message = ( ( ( $message == null) || ( $message == "" ) ) ? "_%" : $message );
// MySQL 검색 실행 및 결과 출력
if(isset($_POST['searchquery'])){
	echo "<script>document.getElementById('categorybox').style.display = 'none'; </script>";
}
if(isset($_POST['category'])) {
	$query = "SELECT * FROM Products WHERE category = '".$category."' and name like '%".$keyword."%'";
} else {
	//$query = "select * from Products where name like '%".$keyword."%' or tags like '%".$keyword."%'";
	$query = "SELECT * FROM Products WHERE name LIKE '%".$keyword."%' OR tag LIKE '%".$keyword."%' OR whichAge LIKE '%".$keyword."%' OR forWhat LIKE '%".$keyword."%'";
}
$result = mysqli_query($conn, $query);

/*만약 퀴리에 맞는 가게가 한 곳도 없다면. 빈 페이지를 출력해줘야함. */
if(mysqli_num_rows($result)==0){
	echo "<div style='height: 383px;'>";
	echo "<h1 style='font-size: 200px; margin: 50px 0px 0px 0px;'>Empty</h1>";
	echo "<span style='color: rgb(180,180,180); position: relative; top: 30px; bottom: 30px; font-size: 20px;'>No Products in this Category</span>";
	echo "</div>";
}else
{

	// AI 추천
	//
	if ($_SESSION['isLogin'] == true) {
	if (isset($_POST['searchquery'])) {
		echo "<h2>Similar Customer's Choices</h2>";
		// 별점이 높은 상품 2개를 선택하는 쿼리
		$tmp_query = "SELECT * FROM Products WHERE name LIKE '%".$keyword."%' OR tag LIKE '%".$keyword."%' OR whichAge LIKE '%".$keyword."%' OR forWhat LIKE '%".$keyword."%' ORDER BY score DESC LIMIT 2";
	} else {
		echo "<h2>AI Recommendations</h2>";
		// 별점이 높은 상품 2개를 선택하는 쿼리
		if (isset($_POST['category'])) {	
			$tmp_query = "SELECT * FROM Products WHERE category = '".$category."' and name like '%".$keyword."%' ORDER BY score DESC LIMIT 2";
		} else {
			$tmp_query = "SELECT * FROM Products ORDER BY score DESC LIMIT 2";
		}
	}

	// 별점이 높은 상품 2개를 선택하는 쿼리
	//$tmp_query = "SELECT * FROM Products WHERE name LIKE '%".$keyword."%' OR tag LIKE '%".$keyword."%' OR whichAge LIKE '%".$keyword."%' OR forWhat LIKE '%".$keyword."%' ORDER BY score DESC LIMIT 2";
	$result = mysqli_query($conn, $tmp_query);

	// 별점이 높은 상품 출력
	while($row = mysqli_fetch_array($result)) {
		echo "<div id='store' style='display: inline-block'><BR><BR>";
		echo "<form action='./review.php' method='post'>";
		echo "<input type='hidden' name='product_id' value='".$row['product_id']."'>";
		echo "<input type='hidden' name='product_name' value='".$row['name']."'>";
		echo "<BR><input type='image' src='".$row['image']."' height='280' width='180'>";

		// 제목 출력
		$shortenedName = substr($row['name'], 0, 20) . '...';
		echo "<BR>".$shortenedName."<BR>";

		// 가격 출력
		echo "Price: USD".$row['price']."<BR>";

		$review_sum = 0; // 리뷰 합계
		$review_cnt = 0; // 리뷰 개수

		$review_score_query = "SELECT score FROM Reviews WHERE product_id = ".$row['product_id'];
		$review_result = mysqli_query($conn, $review_score_query);

		// 리뷰 개수가 0이 아닐 때, 평점 계산하여 띄우기
		if (mysqli_num_rows($review_result) != 0) {
			while($review_row = mysqli_fetch_array($review_result)) {
				$review_sum += $review_row[0];
				$review_cnt++;
			}
			$review_avg = round($review_sum / $review_cnt, 2);
			echo "Score: ".$review_avg;
		} else {
			echo "Score: ".$row['score']." / 5.0";
		}
/*
		// 태그 있으면 출력
		if ($row['tag'] != NULL) {
			echo "<BR>Tags: ".$row['tag'];
		} else {
			echo "<BR><BR>";
		}
 */
		echo "</form>";
		echo "<BR><BR></div>";
	}
	

	// 전체 상품 나열
	//
	//echo "result".count(mysqli_num_rows($result));
	//echo print_r(mysqli_fetch_array($result));
	echo "<h2>All Products</h2>";
	}

	$result = mysqli_query($conn, $query);

	$cnt = 0;

	while($row = mysqli_fetch_array($result)) {
		//echo $cnt;
		if ($cnt >= 4) {
			// 4개 기준 줄바꿈
			echo "<br>";
			$cnt = 0;
		}

		echo "<div id='store' style ='display: inline-block'><BR><BR>";
		echo "<form action='./review.php' method='post'>";
		echo "<input type='hidden' name='product_id' value='".$row['product_id']."'";
		echo "<input type='hidden' name='product_name' value='".$row['name']."'";
		echo "<BR><input type='image' src = '".$row['image']."' height='280' width='180'>";

		// 제목 출력
		$shortenedName = substr($row['name'], 0, 20) . '...';
		echo "<BR>".$shortenedName."<BR>";

		// 가격 출력
		echo "Price: USD".$row['price']."<BR>";

		$review_sum = 0; // 리뷰 합계
		$review_cnt = 0; // 리뷰 개수

		$review_score_query = "select score from Reviews WHERE product_id = ".$row['product_id'];
		$review_result = mysqli_query($conn, $review_score_query);

		// 리뷰 개수가 0이 아닐 때, 평점 계산하여 띄우기
		if (mysqli_num_rows($review_result)!=0) {
			while($review_row = mysqli_fetch_array($review_result)) {
				$review_sum += $review_row[0];
				$review_cnt++;
			}
			$review_avg = round($review_sum / $review_cnt, 2);
			echo "Score: ".$review_avg;
		} else {
			echo "Score: ".$row['score']." / 5.0";
		}
/*
		// 태그 있으면 출력
		if ($row['tag'] != NULL) {
			echo "<BR>Tags: ".$row['tag'];
		} else { echo "<BR><BR>"; }
 */
		echo "</form>";
		echo "<BR><BR></div>";
		$cnt++;
	}
}
// MySQL 드라이버 연결 해제
mysqli_free_result( $result );
mysqli_close( $conn );
?>
	</div>
    </section>
</body>
