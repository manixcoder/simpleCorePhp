<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
	{
	$user_id = $_REQUEST['user_id'];
	
	$r = array();
	$sql = "SELECT * FROM registration WHERE user_id='$user_id'";
	$result = mysqli_query($con, $sql);
	$count = mysqli_num_rows($result);
	$news_feed = mysqli_fetch_assoc($result);
	$user_name = $news_feed['nickname'];
	if ($count > 0)
		{
	$sql1 = "SELECT r.nickname,r.profile_image,ch.* FROM chats ch join registration r on ch.user_id='$user_id' OR ch.opp_id='$user_id' where ch.user_id = r.user_id";
	//$sql1 ="SELECT r.nickname,r.profile_image,ch.* FROM chats ch join registration r on ch.user_id='$user_id' or ch.f_id='$user_id' where ch.f_id=r.user_id or ch.f_id=r.user_id";
		$result1 = mysqli_query($con, $sql1);
		$count1 = mysqli_num_rows($result1);
		while ($result_arr1 = mysqli_fetch_assoc($result1))
			{
			
			/*	$fr = $result_arr1['opp_id'];
				$chat_user_id = $result_arr1['user_id']; 
		
	
				if($fr  == $user_id )
				 {
				 echo 	$sql1 = "SELECT  `nickname`, `profile_image` FROM `registration` WHERE `user_id`='$chat_user_id'";
				 echo "<br>";
				 }
				 else 
				 {
				  $sql1 = "SELECT  `nickname`, `profile_image` FROM `registration` WHERE `user_id`='$fr'";
				 }
				
				$resnum3 = mysqli_query($con, $sql1);
				$res3 = mysqli_num_rows($resnum3);
			
				if ($res3 == 1)
					{
					$result_arr1['f_profile'] = $result_arr1['profile_image'];
					$result_arr1['f_nickname'] = $result_arr1['nickname'];
					
					}
			*/
			   array_push($r, $result_arr1);
			}
		//echo "<pre>";
		//print_r($r);

		if ($count1 > 0)
			{
			$result = array("response" => array('code' => '201','message' => "Chat found successfully",'data' => $r));
			print_r(json_encode($result));
			}
		  else
			{
			$result = array("response" => array('code' => '200','message' => "Chat not found",'data' => $r));
			print_r(json_encode($result));
			}
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => "User not found"));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => "Data not found"));
	print_r(json_encode($result));
	}

?>
