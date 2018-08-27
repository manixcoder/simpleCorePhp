<?php
include ("config/config.php");

  $user_id = $_POST['user_id'];
  $opp_id = $_POST['opp_id'];

	if ($opp_id)
		{
			$id = $opp_id;
		}
  	else
		{
			$id = $user_id;
		}
		
		$r1 = array();
		$r21 = array();
		$r22 = array();

 $qry = "SELECT `username`,`profile_image`,`flag` FROM registration WHERE user_id = '$user_id'";
 $resnum = mysqli_query($con, $qry);
 $res = mysqli_num_rows($resnum);
 if ($res == 1)
	{
	$sql2 = "SELECT r. * , pc. * FROM goodnews pc, registration r WHERE pc.user_id = '$id' AND pc.user_id = r.user_id ORDER BY `gnews_id` DESC ";
	$resnum1 = mysqli_query($con, $sql2);
	$res1 = mysqli_num_rows($resnum1);
	$r = array();
	while ($result_arr = mysqli_fetch_assoc($resnum1))
		{
		if ($result_arr)
			{
			$ff = $result_arr['gnews_id'];
			$sql3 = " SELECT * FROM `goodnews_like`  WHERE `gnews_id` ='$ff' and `user_id` = '$id'";
			$resnum3 = mysqli_query($con, $sql3);
			$res3 = mysqli_num_rows($resnum3);
			$a = array();
			if ($res3 == 1)
				{
				$result_arr['is_like'] = "true";
				}
			         else
				{
				$result_arr['is_like'] = "false";
				}

			array_push($r, $result_arr);
			}
		}

	$count1 = "SELECT COUNT(followers) as followers FROM followers_by_uid WHERE user_id ='$id'";
	$count_nun1 = mysqli_query($con, $count1);
	
	while ($result_arr = mysqli_fetch_assoc($count_nun1))
		{
		array_push($r22, $result_arr);
		}

	$count2 = "SELECT COUNT(following) as following FROM following_by_uid WHERE user_id ='$id'";
	$count_nun2 = mysqli_query($con, $count2);
	while ($result_arr = mysqli_fetch_assoc($count_nun2))
		{
			array_push($r22, $result_arr);
		}

	if ( $res1 > 0)
		{
		$result = array("response" => array('code' => '201','message' => "Data found successfully ...",'data' => $r,'data2' => $r22));
		print_r(json_encode($result));
		}
	  else
		{
		
		$result = array("response" => array('code' => '200','message' => " There is no Good news.",'data' => $r1,'data2' => $r21));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => " There is no Good by user."));
	print_r(json_encode($result));
	}
