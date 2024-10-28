<?php
header('Content-Type: text/html; charset=UTF-8');
include("./SQLconstants.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

$user_id = $_SESSION['user_id'];
$name = $_POST['pet_name'];
$DorC = $_POST['DorC'];
$breed = $_POST['breed'];
$age = $_POST['pet_age'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$vet_visits_freq = $_POST['vet_visits_freq'];
$tooth_brushing_freq = $_POST['tooth_brushing_freq'];
$allergy = $_POST['allergy'];
$disease = $_POST['disease'];
$vaccine = $_POST['vaccine'];

// MySQL 드라이버 연결
$conn = mysqli_connect( $mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database ) or die( "Can't access DB" );

// pet이 등록된 순서가 pet의 id가 되게 하기
$query = "select pet_id from Pets";
$result = mysqli_query($conn, $query);
//$pet_id = mysqli_num_rows($review_result) + 1;
$cnt = 0;
if ($result) {
	while($row = mysqli_fetch_array($result)){
	    if($cnt < $row['pet_id']){
	        break;
	    }
	    else{
	        ++$cnt;
	    }
	}
	mysqli_free_result($result);
} else {
	die("Error in SELECT query: ".mysqli_error($conn));
}

$pet_id = $cnt;

// MySQL 페샤 추가 실행
if(!is_null($_SESSION['user_id'] )) {

    $query = "INSERT INTO Pets ( pet_id, user_id, name, DorC, breed ,age, weight, height, vet_visits_freq, tooth_brushing_freq, allergy, disease, vaccine ) VALUES ( '$pet_id', '$user_id', '$name', '$DorC', '$breed', '$age', '$weight', '$height', '$vet_visits_freq', '$tooth_brushing_freq', '$allergy', '$disease', '$vaccine')";
    $result = mysqli_query( $conn, $query );

    if ($result) {
	    echo "Success to register your pet";
	    //mysqli_free_result( $result );
    } else {
	    echo "Failed to register your pet: ".mysqli_error($conn);
    }
}
else {
    echo "Failed to register your pet";
}

// MySQL 드라이버 연결 해제
mysqli_close( $conn );

?>

<!-- My Page로 돌아가기 -->
<form name="frm" method="post" action="./myInfo.php">
</form>
<script language="javascript">
    document.frm.submit();
</script>
