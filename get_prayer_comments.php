<?php
include ('config/config.php');

if (isset($_REQUEST['prayer_id']) && !empty($_REQUEST['prayer_id']))
	{
	$prayer_id = $_REQUEST['prayer_id'];

	// $query = "SELECT `comment`,`user_id` FROM `prayer_comment` WHERE `prayer_id`='$prayer_id' ";
	// $query = "SELECT  * FROM `prayer_comment` WHERE `prayer_id`='$prayer_id' ";
	// $query="SELECT r.profile_image, r.username, pc. * FROM prayer_comment pc, registration r WHERE pc.prayer_id ='$prayer_id' AND pc.user_id
	// =r.user_id GROUP BY pc.user_id";

	 $query = "SELECT r.*, pc. * FROM prayer_comment pc, registration r WHERE pc.prayer_id ='$prayer_id' AND pc.user_id = r.user_id  ";
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

	if ($records = $resnum->num_rows > 0)
		{
		$result = array("response" => array('code' => '201','message'=> "Data found successfully.",'data' => $r));
		print_r(json_encode($result));
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => " No Comments."));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => "Data Not Found!!."));
	print_r(json_encode($result));
	}