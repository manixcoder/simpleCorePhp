<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
	{
	$user_id = $_REQUEST['user_id'];
	$sql_reg = "SELECT * FROM `registration` WHERE `user_id`='$user_id'";
	$resnum = mysqli_query($con, $sql_reg);
	$res2 = mysqli_num_rows($resnum);
	$res1 = mysqli_fetch_assoc($resnum);
	if ($res1 == true)
		{
		$query = "SELECT  `followers` FROM `followers_by_uid` WHERE `user_id`='$user_id' ";
		$resnum = mysqli_query($con, $query);
		$res = mysqli_num_rows($resnum);
		$r = array();
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			if ($result_arr)
				{
				array_push($r, $result_arr);
				}
			}

		$r2 = array();
		/*  foreach ($r as $user) {
		$vr_ur = $user[followers];
		if($vr_ur==$user_id){ }else{
		$sql2="SELECT * FROM `registration` WHERE `user_id`='$vr_ur'";

		// echo $sql2 = "SELECT r. * FROM followers_by_uid fi, registration r WHERE fi.user_id ='$user_id' AND fi.followers = r.user_id 
		// GROUP BY fi.user_id";

		}

		$resnum2 = mysqli_query($con, $sql2);
		while ($result_arr2 = mysqli_fetch_assoc($resnum2)) {
		if ($result_arr2) {
		array_push($r2, $result_arr2);
		}
		}
		}*/

		// $query = "SELECT `user_id` FROM `following_by_uid` WHERE  `following`='$user_id' ";

		$query = "SELECT `following` FROM `following_by_uid` WHERE  `user_id`='$user_id' ";
		$resnum = mysqli_query($con, $query);
		$res3 = mysqli_num_rows($resnum);
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			if ($result_arr)
				{
				array_push($r, $result_arr);
				}
			}

		// $r = array_unique($r);

		foreach($r as $user)
			{
			$vr_ur1 = $user[following];
			$vr_ur = $user[followers];
			if ($vr_ur == $user_id)
				{
				}
			  else
				{
				if ($vr_ur)
					{
					$sql2 = "SELECT * FROM `registration` WHERE `user_id`='$vr_ur'";
					}
				  else
				if ($vr_ur1)
					{
					$sql2 = "SELECT * FROM `registration` WHERE `user_id`='$vr_ur1'";
					}

				$resnum2 = mysqli_query($con, $sql2);
				$res3 = mysqli_num_rows($resnum2);
				}

			while ($result_arr2 = mysqli_fetch_assoc($resnum2))
				{
				if ($result_arr2)
					{
					array_push($r2, $result_arr2);
					}
				}
			}
		}



	if ($res3 > 0)
		{
		$result = array("response" => array('code' => '201','message' => "Data found successfully.",'data' => $r2));
		print_r(json_encode($result));
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => " User not found.",'data' => $r2));
		print_r(json_encode($result));
		}
	}