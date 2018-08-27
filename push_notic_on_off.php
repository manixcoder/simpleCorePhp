
<?php
include ('config/config.php');


 $user_id = $_POST['user_id'];
 $push_res = $_POST['push_res'];

$qry = "SELECT * FROM `registration` WHERE `user_id`='$user_id '";
$resnum = mysqli_query($con, $qry);
$res = mysqli_num_rows($resnum);

if ($res != 0)
	{
	$sql = "UPDATE `registration` SET `push_res`='$push_res' WHERE `user_id`='$user_id'";
	$sql_ex = mysqli_query($con, $sql);
	if ($sql_ex)
		{
		
		if ($push_res == '1')
			{
			$result = array("response" => array('code' => '201','message' => "Push notification Successfully on!"));
			print_r(json_encode($result));
			}
		  else
			{
			$result = array("response" => array('code' => '200','message' => "Push notification Successfully off!"));
			print_r(json_encode($result));
			}
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => "Query fail!"));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => "User not found!"));
	print_r(json_encode($result));
	}

