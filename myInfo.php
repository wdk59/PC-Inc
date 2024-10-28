<?php // 내 정보 페이지
header('Content_Type: text/html; charset=UTF-8');
//include './WriteLog.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();
$session_id = $_SESSION['session_id'];
// 로그인했는지 검사
if ($_SESSION['isLogin'] != true) {
	// 로그인하지 않았다면 로그인 화면으로 이동
	header('Location: login.php');
}
$message = "";
#log_write($session_id, "내 정보 화면 접속");
?>

<html>

<head>
<script type="text/javascript">
function showMessage(message) {
	if ((message != null) && (message != "") && (message.substring(0, 3) == " * ")) {
		alert(message);
	}
}
// 지정한 url로 이동하는 함수
function move(url) {
	document.formm.action = url;
	document.formm.submit();
}
</script>
    <meta charset="utf-8" />
    <title>PetCare v0.1 - My Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body onLoad="showMessage( '<?php echo $_POST['message'];?>' );">

    <!--메뉴바-->
    <nav class="menubar">
	<ul class="menu">
	    <li><a href="Main.php">
		    <h1 class="logo">Pet Care</h1>
		</a></li>
	    <li style="margin-left: 680px;">
		<h1 class="logo">My Page</a>
	    </li>
	</ul>
	<ul class="mydata">
	    <li><a href="logout.php">Sign out</a></li>
	</ul>
    </nav>

    <section>
	<div id="loginbox" style="height:auto;">
<?php
// 회원의 정보는 로그인 시 SESSION에 저장되므로 DB에 접근하지 않음 

// SESSION에 회원 정보가 없을 경우 빈 페이지 띄우기
if ($_SESSION['user_id']== NULL) {
	/*
		log_write($_SESSION['session_id'], "[ ".$_SESSION['user_id']." ] 회원 정보 조회 오류");
		log_write($_SESSION['session_id'], "이름: ".$_SESSION['name']);
		log_write($_SESSION['session_id'], "나이: ".$_SESSION['age']);
		log_write($_SESSION['session_id'], "성별: ".$_SESSION['gender']);
		log_write($_SESSION['session_id'], "좋아하는 음식: ".$_SESSION['favorite_food']);
		log_write($_SESSION['session_id'], "식객지수: ".$_SESSION['gourmet_score']);
	 */
	echo "<div style='height: 383px;'>";
	echo "<h1 style='font-size: 300px; margin: 50px 0px 0px 0px;'>Error</h1>";
	echo "<span style='color: rgb(180, 180, 180); position: relative; bottom: 30px; font-size: 20px;'>오류: 회원 정보가 없습니다. 관리자에게 문의하세요.</span>";
	echo "</div>";
} else {
	//log_write($_SESSION['session_id'], $_SESSION['user_id'].": 회원 정보 조회 성공");

	/* 왼쪽 블록 */
	// 프로필 아이콘 및 이름
	echo "<div id='my_info' style='width:40%; display:inline-block; vertical-align:top; margin: 0% 1% 0% 2%;'>";

	echo "<div id='my_name' style='display:inline-block;'>";
	echo "<img src='https://cdn-icons-png.flaticon.com/512/6522/6522516.png' style='display: inline-block; position: relative; width: 20%; float:left;'></img>";
	echo "<h1 style='display:inline-block; position: relative; width:75%; font-size: 45px; text-align:left;'>".$_SESSION['name']."</h1>";
	// 세부 정보
	echo "<form style='font-size:35px; display: inline-block; width:95%; text-align:left; position:relative; margin:5% 0% 0% 5%'>";
	//echo "<br><br> I &nbsp; &nbsp; D &nbsp;: ".$_SESSION['user_id'];
	echo "ID: ".$_SESSION['user_id'];
	echo "<br><br>Age: ".$_SESSION['age'];
	echo "<br><br>Address: ".$_SESSION['address'];

	echo "</form>";
	echo "</div>";
	echo "</div>";

	/* 오른쪽 블록 */
	echo "<div id='pet_info' style='width:40%; display:inline-block; vertical-align:top; margin: 0% 2% 0% 1%;'>";

	include './SQLconstants.php';
	// MySQL 드라이버 연결
	$conn = mysqli_connect($mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database) or die ("Cannot access DB");
	$query = "select * from Pets where user_id = '".$_SESSION['user_id']."'";
	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result)==0){
		echo "<form action='./addPet.php' method='post' style='display:inline-block; float:left'>";
		echo "<input type='submit' value='Register Pet' style='padding:5px; border-radius:8px; background-color:rgb(255,145,70); color:white; width:100%; font-size:30px; border-color:white; border-width:0px; position:relative; bottom:10%; right:2%;'>";
		echo "</form>";
	}
	else {
		$row = mysqli_fetch_array($result);
		echo "<div id='pet_name' style='display:inline-block;'>";
		echo "<img src='https://cdn-icons-png.flaticon.com/128/672/672716.png' style='display: inline-block; position: relative; width: 20%; float:left;'></img>";
		echo "<h1 style='display:inline-block; position: relative; width:75%; font-size: 45px; text-align:left;'>".$row['name']."</h1>";
		// 세부 정보
		echo "<form style='font-size:35px; display: inline-block; width:95%; text-align:left; position:relative; margin:5% 0% 0% 5%'>";
		//echo "<br><br> I &nbsp; &nbsp; D &nbsp;: ".$_SESSION['user_id'];
		echo "".$row['DorC']." / ".$row['breed'];
		echo "<br><br>Age: ".$row['age'];
		echo "<br><br>".$row['weight']."kg / ".$row['height']."cm";
		echo "<br><br>Vet Visits: every ".$row['vet_visits_freq']."month(s)";
		echo "<br><br>Tooth brushing frequency:<br>every ".$row['vet_visits_freq']."day(s)";
		echo "<br><br>Allergy: ".$row['allergy'];
		echo "<br><br>Disease: ".$row['disease'];
		echo "<br><br>Vaccine: ".$row['vaccine'];

		// 펫 정보 수정 버튼

		echo "</form>";
		echo "</div>";
	}

	// MySQL 드라이버 연결 해제
	mysqli_free_result( $result );
	mysqli_close( $conn );

	echo "</div>";
}
?>
	</div>
    </section>
</body>
