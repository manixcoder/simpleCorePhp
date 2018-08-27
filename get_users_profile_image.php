<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&& isset($_REQUEST['opp_id']) && !empty($_REQUEST['opp_id']))
	{
	 $user_id = $_REQUEST['user_id'];
	 $opp_id = $_REQUEST['opp_id'];
	 
	 $sql_reg = "SELECT * FROM `registration` WHERE `user_id`='$user_id'";
	$resnum = mysqli_query($con, $sql_reg);
	$res1 = mysqli_fetch_assoc($resnum);
	$res2 = mysqli_num_rows($resnum);
	if ($res1 == true)
		{
		$member_id = explode(',',$opp_id );
		$r = array();
		foreach($member_id as $mid){
		   $sql="SELECT `user_id`,`profile_image` FROM `registration` WHERE `user_id`='$mid'";
		    $resnum = mysqli_query($con, $sql);
		    
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			if ($result_arr)
				{
				array_push($r, $result_arr);
				}
			}
		
		}
		
		$result = array(
			"response" => array(
				'code' => '201',
				'message' => "Data found successfully.",
				'data' => $r
			)
		);
		print_r(json_encode($result));
		
		}else{
		$result = array(
			"response" => array(
				'code' => '200',
				'message' => "User  not found."
				
			)
		);
		print_r(json_encode($result));
		
		}
		
		
	}else{
	$result = array(
			"response" => array(
				'code' => '200',
				'message' => "Data not found."
				
			)
		);
		print_r(json_encode($result));
	
	}