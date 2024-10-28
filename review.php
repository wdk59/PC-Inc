<?php
	header('Content_Type: text/html; charset=UTF-8');
	include 'WriteLog.php';
	session_start();
	#log_write(session_id(), "리뷰 화면 접속");
	$p_id = $_POST['product_id'];
	$p_name = $_POST['product_name'];

	if($_SESSION['isLogin'] == true) {
		$login_text = 'My Page';
	} else {
		$login_text = 'Log in';
	}
?>
<html>

<head>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=3f6bc7aceaa51a0bd1d84d6651f70d27&libraries=services"></script>
    <style>
        #imgbox {
            width: 100%;
            height: 300px;
            overflow: hidden;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        #reviewscore {
            display: inline-block;
            position: relative;
            left: 560px;
            bottom: 135px;
        }

        #reviewdata {
            display: inline-block;
            position: relative;
            bottom: 100px;
            right: 430px;
            text-align: left;
        }

        #reviewuser {
            display: inline-block;
            position: relative;
            right: 630px;
        }
    </style>
    <title>PetCare v0.1 - ProductPage</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!--메뉴바--!>
         <nav class="menubar">
	     <ul class="menu">
	       <li><a href="Main.php"><h1 class="logo">Pet Care</h1></a></li>
               <li style="margin-left: 450px;"><h1 class="logo">Product Page</a></li>
             </ul>
	     <ul class="mydata">
<!--
               <li><a href="add.php">맛집 추가</a></li>
               <li><a href="delete.php">맛집 삭제</a></li>
-->
	       <li><a href="login.php"><?=$login_text?></a></li>
             </ul>
	  </nav>

	
		</div>
	   </div>
         </section>
              <section>
               <div id="storebox" style="height:900px margin-top:0px;">
               <?php
	       // MySQL 드라이버 연결
	       include './SQLconstants.php';
	       $conn = mysqli_connect($mySQL_host, $mySQL_id, $mySQL_password, $mySQL_database) or die ("Cannot access DB");
	   
	       // 전달 받은 메시지 확인
	       $message = $_POST['message'];
	       $message = ( ( ( $message == null) || ( $message == "" ) ) ? "_%" : $message );
	   
	       // MySQL 검색 실행 및 결과 출력
	       $query = "select * from Restaurants where restaurant_id = ".$r_id."";
	       $result = mysqli_query($conn, $query);
	       while($row = mysqli_fetch_array($result)){
	           echo "<div id='imgbox'><img src = '".$row['picture']."'style='width:100%;height:100%;object-fit:cover;'></div>";
	           echo "<BR><div style='position: relative; text-align: left; left:100px;font-size:30px;'> ID : ".$row['restaurant_id'];
	           echo "<BR><span id='storetext'>식당 이름 : ".$row['name']."</span>";
	           echo "<BR> <span id='storetext'>메뉴 : ".$row['menu']."</span>";
	           echo "<BR><span id='storetext'> 주소 : ".$row['address']."</span>";
	           echo "<BR> <span id='storetext'>전화번호 : ".$row['phone']."</span>";
	           echo "<BR><span id='storetext'> 영업 시간 : ".$row['opening_hour']."</span>";
	           echo "<BR> <span id='storetext'>배달 : ".$row['delivery']."</span>";
	           echo "<BR><span id='storetext'> 포장 : ".$row['take_out']."</span>";
	           echo "<BR><span id='storetext'> 태그 : ".$row['tag']."</span>";
	           echo "</div><BR><BR>";
	           $r_add = $row['address'];
	       }
	       ?>
	       
	       <div id="map" style="width:400px;height:300px; display: inline-block; bottom : 345px; left: 500px;margain: 0px 100px 100px 70px;"></div>
	     </div>
              <div id="reviewbox">
               <div style="text-align: left; position: relative; left: 90px; margin-top: 20px;"> 
                
         <form action="./reviewSQL.php" method="post"style="display:inline-block;width:1500px;">
            <textarea name="review" cols="30" rows="4" placeholder="리뷰는 120자까지 입력할 수 있습니다." required style="border-radius:40px;width:70%;padding: 20px;font-size:20px;"></textarea>
        
           <input type="number" name="score" style="position: relative; width:100px; height:57px; font-size:30px; border-radius: 30px;padding-left:13px; margin: 0px; bottom: 84px; left: 115px;"placeholder="0" min="0" max="5" required>
           <input type='hidden' name='restaurant_id' value='<?php echo $r_id?>'>
           <input type='hidden' name='restaurant_name' value='<?php echo $r_name?>'>
           <input type='hidden' name='user_id' value='<?php echo $_SESSION['user_id'];?>'>
           <input type="submit" value='리뷰 작성'style="padding: 5px; border-radius:8px; background-color: rgb(255,145,70); color: white; width: 130px; font-size:30px; border-color: white; border-width: 0px; position: relative; bottom:20px;right: 3px;">
              </div>
		</form> 
               <hr>
       <?php
       
	   $query = "select * from Reviews where restaurant_id = ".$r_id."";
	   $result = mysqli_query($conn, $query);
       	while($row = mysqli_fetch_array($result)){
	   $selected_user_id = $row['user_id'];
	   //log_write($_SESSION['session_id'], $selected_user_id."post 성공했겠지...?");
	   echo "<BR><BR>";
	   echo "<div id='reviewuser'>";
	   echo "<form action='./userInfo.php' method='POST'>";
	   echo "<input type='hidden' name='user_info' value=".$selected_user_id.">";
	   echo "<input type='image' src='https://cdn-icons-png.flaticon.com/512/6522/6522516.png' style='width:100px'><BR>".$row['user_id'];
	   echo "</form>";
	   /*
	   echo "<a href='myInfo.php' style='color: black'>";
	   echo "<img src='https://cdn-icons-png.flaticon.com/512/6522/6522516.png' style='width:100px'><BR>".$row['user_id'];
	   echo "</a>";
	    */
	   echo "</div>";
	   echo "<BR><div id='reviewdata'>".$row['upload_date'];
	   echo "<BR>".$row['content']."</div>";
	   echo "<BR><div id='reviewscore'>점수 : ".$row['score'];
	   if ($_SESSION['user_id'] != $selected_user_id) {
	       echo "<form action='./likedislikeSQL.php' method='post'style='isplay:inline-block;width:1500px;'>";
	       echo "<input type='hidden' name='my_review_id' value=".$row['review_id'].">";
	       echo "<input type='hidden' name='selected_user' value=".$selected_user_id.">";
	       echo "<BR> <input type='submit' name='ldlsubmit' value='좋아요'style='padding: 5px; border-radius:8px; background-color: rgb(0,100,255); color: white; width: 50px; font-size:15px; border-color: white; border-width: 0px; position: relative;'> : ".$row['likes'];
	       echo "<BR> <input type='submit' name='ldlsubmit' value='싫어요'style='padding: 5px; border-radius:8px; background-color: rgb(255,30,0); color: white; width: 50px; font-size:15px; border-color: white; border-width: 0px; position: relative;'> : ".$row['dislikes'];
	       echo "</form></div>";
	   }
	   else{
	       echo "<BR> 좋아요 : ".$row['likes'];
	       echo "<BR> 싫어요 : ".$row['dislikes']."</div>";
	   }
	   echo "<BR>";
	   if ($_SESSION['user_id'] == $selected_user_id) {
	       echo "<form action='./deletereviewSQL.php' method='post'style='isplay:inline-block;width:1500px;'>";
	       echo "<input type='hidden' name='my_review' value=".$row['content'].">";
	       echo "<input type='submit' value='리뷰 삭제'style='padding: 5px; border-radius:8px; background-color: rgb(255,145,70); color: white; width: 80px; font-size:15px; border-color: white; border-width: 0px; position: relative; bottom:0px;right: 0px;'>";
	       echo "</form>";
	   }
	   echo "<hr>";
       }
   
       // MySQL 드라이버 연결 해제
       mysqli_free_result( $result );
       mysqli_close( $conn );
?> 
       		   <div>
                <span><?php echo $_SESSION['user_id'];?></span>
           </div>
            
	     </div>
            </section>
            
           <script>	
			var mapContainer = document.getElementById("map");
			var options = {
				center: new kakao.maps.LatLng(37.602322, 126.955350),
				level: 3
                        };

			var map = new kakao.maps.Map(mapContainer, options);
			var markers = [];
			
			map.setDraggable(false);

			marker = new kakao.maps.Marker({
    			map: map,
    	    	position: new kakao.maps.LatLng(37.6023222243288, 126.955350026719)
    		});
    		marker.setMap(map);
    		markers.push(marker);
			
			var callback = function(result, status) {
				if(status === kakao.maps.services.Status.OK) {
					hideMarkers();
					marker = new kakao.maps.Marker({
				   		map: map,
				   		position: new kakao.maps.LatLng(result[0].y, result[0].x)
				   	});
				   	map.setCenter(new kakao.maps.LatLng(result[0].y, result[0].x));
					marker.setMap(map);
					markers.push(marker);
					document.getElementById('id').value = result[0]['id'];
					document.getElementById('name').value = result[0]['place_name'];
					document.getElementById('address').value = result[0]['address_name'];
					document.getElementById('pn').value = result[0]['phone'];
				}
			};
				
			function setMarkers(map) {
				   for (var i = 0; i < markers.length; i++) {
				   	markers[i].setMap(map);
				   }
			}

			function hideMarkers() {
				   setMarkers(null);
			}

			var places = new kakao.maps.services.Places(map);
            
		    places.keywordSearch('<?php echo $r_add;?>', callback, 'FD6');

			function Enter() {
				   if(event.keyCode == 13) {
				   	printPlace();
				   }
			}
		</script>
	</body>
</html>
