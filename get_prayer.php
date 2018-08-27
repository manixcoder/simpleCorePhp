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

$qry = "SELECT `username`,`profile_image`,`flag` FROM registration WHERE user_id = '$user_id'";
$resnum1 = mysqli_query($con, $qry);
$res1 = mysqli_num_rows($resnum1);

if ($res1 == 1)
	{
	$sql = "SELECT r. * , pc. * FROM add_prayer pc, registration r WHERE pc.user_id = '$id' AND pc.user_id = r.user_id ORDER BY `pr_id` DESC  ";
	$resnum = mysqli_query($con, $sql);
	$res = mysqli_num_rows($resnum);
	$r = array();
	while ($result_arr = mysqli_fetch_assoc($resnum))
		{
		if ($result_arr)
			{
				
			$ff = $result_arr['pr_id']; 
			
		   $sql3 = " SELECT * FROM `prayer_like`  WHERE `prayer_id` ='$ff' and `user_id` = '$user_id'";
			$resnum3 = mysqli_query($con, $sql3);
			$res3 = mysqli_num_rows($resnum3);
			$a = array();
			if ($res3 == '1')
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
	$r22 = array();
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

	if ($res)
		{
		  $result = array("response" => array('code' => '201','message' => "Data found successfully..",'data' => $r,'data2' => $r22));
		  print_r(json_encode($result));
		}
	  else
		{
		  $result = array("response" => array('code' => '200','message' => "There is no Prayer..",'data' => $r1,'data2' => $r21));
		  print_r(json_encode($result));
		}
	}
  else
	{
	   $result = array("response" => array('code' => '200','message' => "There is no Prayer by user.",'data' => $r1));
	   print_r(json_encode($result));
	}
