 <?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
	{
	$user_id = $_REQUEST['user_id'];

	// $query = "SELECT `following`, `username`, `profile_image`,`vocation` FROM `following_by_uid` WHERE  `user_id`='$user_id' ";

	$query = "SELECT `following` FROM `following_by_uid` WHERE  `user_id`='$user_id' ";
	$resnum = mysqli_query($con, $query);
	$res = mysqli_num_rows($resnum);
	$r = array();
	while ($result_arr = mysqli_fetch_assoc($resnum))
		{
		if ($result_arr)
			{
			array_push($r, $result_arr);
			}
		  else
			{
			$result = array("response" => array('code' => '200','message' => "Follower  not found"));
			print_r(json_encode($result));
			}
		}

	$r2 = array();
	foreach($r as $user)
		{
		$vr_ur = $user[following];
		$sql2 = "SELECT * FROM `registration` WHERE `user_id`='$vr_ur'";

		// $sql2 = "SELECT r. * FROM following_by_uid fi, registration r WHERE fi.user_id ='$user_id' AND fi.following = r.user_id GROUP BY fi.user_id";

		$resnum2 = mysqli_query($con, $sql2);
		while ($result_arr2 = mysqli_fetch_assoc($resnum2))
			{
			if ($result_arr2)
				{
				array_push($r2, $result_arr2);
				}
			  else
				{
				$result = array("response" => array('code' => '200','message' => "Prayer Likes not found"));
				print_r(json_encode($result));
				}
			}
		}

	if ($records = $resnum-> num_rows > 0)
		{
		$result = array("response" => array('code' => '201','message' => "Data  found successfully by the user.",'data' => $r2));
		print_r(json_encode($result));
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => " you did Not follow any one."));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => "Data Not Found!!."));
	print_r(json_encode($result));
	}
