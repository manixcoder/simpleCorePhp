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
	
	if ($count > 0)
		{
	    $sql_ch = "SELECT * FROM `chats` WHERE `user_id`='$user_id' OR `opp_id`='$user_id'";
	    $ex_ch = mysqli_query($con, $sql_ch);
	    $row = mysqli_num_rows($ex_ch);
	    if ($row > 0)
			{
			  $sql_del = "DELETE FROM `chats` WHERE `user_id`='$user_id' OR `opp_id`='$user_id'";
			  $ess = mysqli_query($con, $sql_del);
			  $sql_rec = "DELETE FROM `recent_chat` WHERE `user_id`='$user_id' OR `opp_id`='$user_id'";
			  $sql_re = mysqli_query($con, $sql_rec);
			  if($sql_re)
			  {
			  	$result = array("response" => array('code' => '201','message' => "Chat delete Successfully"));
			  	print_r(json_encode($result));
			  }
			  else 
			  {
			  	$result = array("response" => array('code' => '200','message' => "Chat not found"));
			  	print_r(json_encode($result));
			  }
			}
		  else
			{
			$result = array(
				"response" => array(
					'code' => '200',
					'message' => "Chat not found"
				)
			);
			print_r(json_encode($result));
			}
		}
	  else
		{
		$result = array(
			"response" => array(
				'code' => '200',
				'message' => "User not found"
			)
		);
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array(
		"response" => array(
			'code' => '200',
			'message' => "Data not found"
		)
	);
	print_r(json_encode($result));
	}
