<?php // 펫 추가 페이지
header('Content_Type: text/html; charset=UTF-8');

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
		<h1 class="logo">Register Pet</a>
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
	echo "<div style='height: 383px;'>";
	echo "<h1 style='font-size: 300px; margin: 50px 0px 0px 0px;'>Error</h1>";
	echo "<span style='color: rgb(180, 180, 180); position: relative; bottom: 30px; font-size: 20px;'>오류: 회원 정보가 없습니다. 관리자에게 문의하세요.</span>";
	echo "</div>";
} else {
	/* 왼쪽 블록 */
	// 질문
	echo "<div id='pet_question' style='width:30%; display:inline-block; vertical-align:top; margin: 0% 1% 0% 2%;'>";
	echo "<form style='font-size:20px; display: inline-block; width:95%; text-align:right; position:relative; margin:5% 0% 0% 5%'>";

	echo "<br><br>Pet's name: ";
	echo "<br><br>Dog or Cat: ";
	echo "<br><br>Pet breed: ";
	echo "<br><br>Pet's age: ";
	echo "<br><br>Pet's weight(kg): ";
	echo "<br><br>Pet's height(cm): ";
	echo "<br><br>Vet visits Frequency(months): ";
	echo "<br><br>Tooth brushing Frequency(days): ";
	echo "<br><br>allergy: ";
	echo "<br><br>disease: ";
	echo "<br><br>vaccine: ";	

	echo "</form>";
	echo "</div>";

	/* 오른쪽 블록 */
	// 답변
	echo "<div id='pet_answer' style='width:50%; display:inline-block; vertical-align:top; text-align:left; margin: 0% 2% 0% 1%;'>";	
	echo "<form action='./addPetSQL.php' method='post' style='display:inline-block;wdith:100%'>";

	echo "<br><br><p><input type='text' name='pet_name' style='height: 30px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='DorC' style='height: 30px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='breed' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='pet_age' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='weight' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='height' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='vet_visits_freq' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='tooth_brushing_freq' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='allergy' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='disease' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";
	echo "<p><input type='text' name='vaccine' style='height: 29px; border-radius:30px;padding-left: 15px; font-size: 20px;'required></p>";

	echo "<input type='submit' value='Submit' style='padding:5px; border-radius:8px; background-color:rgb(255,145,70); color:white; width:100%; font-size:30px; border-color:white; border-width:0px; position:relative; bottom:10%; right:2%;'>";

	echo "</form>";
	echo "</div>";
}

?>
