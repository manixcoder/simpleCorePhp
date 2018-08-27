<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
	{
	$user_id = $_REQUEST['user_id'];
	$r = array();
	$r2 = array();
	$qry = "SELECT * FROM registration WHERE user_id = '$user_id'";
	$resnum1 = mysqli_query($con, $qry);
	$res1 = mysqli_num_rows($resnum1);
	if ($res1 == 1)
		{
		$query = "SELECT `followers` FROM `followers_by_uid` WHERE  `user_id`='$user_id'";
		$resnum = mysqli_query($con, $query);
		$res1 = mysqli_num_rows($resnum);
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			array_push($r, $result_arr);
			}

		$query = "SELECT `following` FROM `following_by_uid` WHERE  `user_id`='$user_id'";
		$resnum = mysqli_query($con, $query);
		$res1 = mysqli_num_rows($resnum);
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			array_push($r, $result_arr);
			}

		foreach($r as $value)
			{
			$id[] = $value['followers'];
			$id[] = $value['following'];
			}

	$ff = implode(',', $id);

	$hh = array_unique(explode(',',$ff));
             
		foreach($hh as $val)
			{
			
			$sql = "SELECT  * FROM `registration` WHERE `user_id`='$val'";
			$res = mysqli_query($con, $sql);
			$row = mysqli_num_rows($res);
			
			while ($result = mysqli_fetch_assoc($res))
				{
				array_push($r2, $result);
				}
			}
			
		
			if($row > 0)
			{
			$result = array("response" => array('code' => '200','message' => "Data found Successfully",'data'=>$r2));
	      print_r(json_encode($result));
			}
			else
			{
			$result = array("response" => array('code' => '200','message' => "There is no users",'data'=>$r2));
			print_r(json_encode($result));
			}

		
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
