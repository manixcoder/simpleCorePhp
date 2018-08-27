<?php

include ('config/config.php');

if (isset($_REQUEST['prayer_id']) && !empty($_REQUEST['prayer_id']) 
&& isset($_REQUEST['opp_id']) && !empty($_REQUEST['opp_id']))
	{
	$p_id = $_REQUEST['prayer_id'];
	$opp_id = $_REQUEST['opp_id'];
		
	$sql = "SELECT * FROM `add_prayer` WHERE `pr_id`='$p_id'";
	$resnum = mysqli_query($con, $sql);
	$res1 = mysqli_num_rows($resnum);
	if ($res1 != 0) 
			{
		$sql2 = "SELECT `following` FROM `following_by_uid` WHERE `user_id` ='$opp_id'";
		$resnum2 = mysqli_query($con, $sql2);
		$r2 = array();
		while ($result_arr2 = mysqli_fetch_assoc($resnum2))
			{
			if ($result_arr2)
				{
				array_push($r2, $result_arr2);
				}
			 
			}

		$query = "SELECT r . * , pc . * FROM prayer_like pc, registration r WHERE pc.prayer_id ='$p_id' AND pc.user_id = r.user_id GROUP BY pc.user_id";
		$resnum = mysqli_query($con, $query);
		$res = mysqli_num_rows($resnum);
		$r = array();
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			if ($result_arr)
			{
				$ff = $result_arr['user_id'];
				$sql3 = "SELECT `following` FROM `following_by_uid` WHERE `following` ='$ff' and `user_id` = '$opp_id'";
				$resnum3 = mysqli_query($con, $sql3);
				$res3 = mysqli_num_rows($resnum3);
				
				if ($res3 == 1)
					{
					$result_arr['is_follow'] = "true";
					}
				  else
				  {
				 $result_arr['is_follow'] = "false";
				 }

				array_push($r, $result_arr);
				}
			
			}

		 $result1 = array_intersect($r, $r2);
		 //echo "<pre>";print_r($result1);die;
		 if ($res1 > 0)
			{
			$result = array("response" => array('code' => '201','message' => "Data found successfully ..",'data' => $r));
			print_r(json_encode($result));
			}
		  else
			{
			$result = array("response" => array('code' => '200','message' => " There is not Preyer."));
			print_r(json_encode($result));
			}
		}else{
		$result = array("response" => array('code' => '200','message' => "Prayer not fond."));
		print_r(json_encode($result));
		}
	}
  else
	{
	
	$result = array("response" => array('code' => '200','message' => " Data not found."));
	print_r(json_encode($result));
	}
