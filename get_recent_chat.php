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
		$sql1 = "SELECT r.*,ch.* FROM recent_chat ch join registration r on ch.user_id='$user_id'  where ch.opp_id = r.user_id";
		$result1 = mysqli_query($con, $sql1);
		$count1 = mysqli_num_rows($result1);
		while ($result_arr1 = mysqli_fetch_assoc($result1))
			{
			   array_push($r, $result_arr1);
			}
		$sql1 = "SELECT r.*,ch.* FROM recent_chat ch join registration r on ch.opp_id='$user_id' where ch.user_id = r.user_id";
		$result1 = mysqli_query($con, $sql1);
		$count1 = mysqli_num_rows($result1);
		while ($result_arr1 = mysqli_fetch_assoc($result1))
			{
			   array_push($r, $result_arr1);
			}
	

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
