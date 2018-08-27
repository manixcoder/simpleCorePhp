<?php
include ('config/config.php');

if (isset($_REQUEST['email']) && !empty($_REQUEST['email']))
	{
	$email = $_REQUEST['email'];
	
	$status = 1;
	
	$sql_reg = "SELECT * FROM `registration` WHERE `username`='$email'";
	$resnum = mysqli_query($con, $sql_reg);
	$res = mysqli_num_rows($resnum);
	if ($res != 0)
		{
		$sql = "UPDATE `registration` SET `status`='$status' WHERE `username`='$email'";
		$resnum = mysqli_query($con, $sql);
		if ($resnum)
			{
			$reg = "SELECT * FROM `registration` WHERE `username`='$email'";
			$resnum1 = mysqli_query($con, $reg);
			$res1 = mysqli_fetch_assoc($resnum1);
			if ($resnum)
				{
				$result = array("response" => array('code' => '201','message' => "Data found Successfully.",'data' => $res1));
				print_r(json_encode($result));
				}
			}		
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => "email not found "));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' =>'200','message' => "email not found "));
	print_r(json_encode($result));
	}
