<?php
	header('Content-Type: text/html; charset=UTF-8');
	include("./SQLconstants.php");
	session_start();

	/* 최초 접근 시 */
	if($_SESSION['session_id'] == NULL) {
		echo '<script>alert("세션 id 초기화");</script>';
		$_SESSION['session_id'] = session_id();
	}

	/* 세션에 저장된 회원 정보 초기화 */
	$_SESSION['user_id'] = NULL;
	$_SESSION['name'] = NULL;
	$_SESSION['age'] = NULL;
	$_SESSION['address'] = NULL;
	$_SESSION['pet_id'] = NULL;
	$_SESSION['subscription'] = NULL;
	$_SESSION['membership'] = NULL;
	$_SESSION['mem_points'] = NULL;
	$_SESSION['order_history'] = NULL;
	$_SESSION['isLoogin'] = false;
?>

<html lang="ko">
  <head>

	<script type="text/javascript">
                        function showMessage( message )
                        {
                                if ( ( message != null ) && ( message != "" ) && ( message.substring( 0, 3 ) == " * " )  )
                                {
                                        alert( message );
                                }
                        }
                        // 지정한 url로 이동하는 함수
			function move( url )
			{
				document.formm.action = url;
				document.formm.submit();
			}
	</script>

	<meta charset="utf-8">
    	<style>
	</style>
	<title>PetCare v0.1 - Log out</title>
	<link rel="stylesheet" href="style.css">
   </head>
   <body onLoad="showMessage( '<?php echo $_POST['message']?>' );">
	<!--메뉴바-->
	<nav class="menubar">
		<ul class="menu">
			<li><a href="Main.php"><h1 class="logo">Pet Care</h1></a></li>
 	                <li style="margin-left: 700px;"><h1 class="logo">Log out</a></li>
		</ul>
		<ul class="mydata">
			<!--<li><a href="add.php">맛집 추가</a></li>
			<li><a href="delete.php">맛집 삭제</a></li>-->
			<li><a href="login.php">Log in</a></li>
		</ul>
	</nav>
	<section>
        <div id="loginbox">
	  <div id="logout_success">
		<form style='font-size: 40px; width: 700px; display: inline-block; position: relative; bottom: 30px;'>
			<?php
				/* 세션에 저장된 회원 정보 초기화 */
				$_SESSION['user_id'] = NULL;
				$_SESSION['name'] = NULL;
				$_SESSION['age'] = NULL;
				$_SESSION['address'] = NULL;
				$_SESSION['pet_id'] = NULL;
				$_SESSION['subscription'] = NULL;
				$_SESSION['membership'] = NULL;
				$_SESSION['mem_points'] = NULL;
				$_SESSION['order_history'] = NULL;
				$_SESSION['isLogin'] = false;

				if ($_SESSION['isLogin'] == true) {
					echo "<br><br>Failed to Sign out<br><br>";
				} else {
					echo "<br><br>Success to Sign out<br><br>";
				}
			?>

		<input type="button" value="To Log in" style="border-radius:8px;background-color: rgb(255, 145, 70); color: white; width: 250px; font-size: 30px; border-color: white; padding: 10px 12px; position: relative;  right: 100px; border-width:0px;" onClick="location.href='login.php'">
		<input type="button" value="To Main" style="border-radius:8px;background-color: rgb(255, 145, 70); color: white; width: 250px; font-size: 30px; border-color: white; padding: 10px 12px; position: relative; left: 100px;border-width:0px;" onClick="location.href='Main.php'">
         	</div>
          </div>
	</section>
	</body>
</html>

