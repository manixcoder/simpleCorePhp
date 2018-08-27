<?php
include ("config/config.php");

$nickname = $_POST['nickname'];
$email = $_POST['email'];
$password = $_POST['password'];
$nationality_id = $_POST['nationality_id'];
$vocation = $_POST['vocation'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$language = $_POST['language'];
$device_id = $_POST['device_id'];
$device_type = $_POST['device_type'];

if (!empty($email))
	{
	$status = '1';
	$push_res = '1';
	$image1 = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
	$sql_reg = "SELECT * FROM `registration` WHERE `username`='$email' or `username`='$nickname'";
	$resnum = mysqli_query($con, $sql_reg);
	$res = mysqli_num_rows($resnum);
	if ($res == 0)
		{
		$sqll = "SELECT  `id`,`name`, `flag` FROM `nationality` WHERE `id`='$nationality_id'";
		$resnum3 = mysqli_query($con, $sqll);
		$res3 = mysqli_num_rows($resnum3);
		while ($news_feed = mysqli_fetch_assoc($resnum3))
			{
			$nationality_name = $news_feed['name'];
			$flag = $news_feed['flag'];
			}

		$sql_l = "SELECT * FROM `select_language` WHERE `language`='$language'";
		$resnum_l = mysqli_query($con, $sql_l);
		$res_l = mysqli_num_rows($resnum_l);
		$l_c = mysqli_fetch_assoc($resnum_l);
		$l_code = $l_c['code'];
		if ($image1 != '')
			{
			$file_path = "uploads/";
			$file_path = $file_path . basename($_FILES['image']['name']);
			move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
			if ($image1 != '')
				{
				$p_image = "asone_app/uploads/" . $image1;
				}
			  else
				{
				$p_image = '';
				}
			}

		$sql2 = "INSERT INTO `registration`(`nickname`,`username`,`date_birthday`,`password`,`nationality`,`nationality_id`, `vocation`, `gender`, `language`,`l_code`,
                 `profile_image`, `flag`, `device_id`, `device_type`,`push_res`) VALUES ('$nickname','$email','$birthday','$password','$nationality_name','$nationality_id','$vocation','$gender','$language','$l_code','$p_image','$flag','$device_id','$device_type','$push_res')";
		$resnum2 = mysqli_query($con, $sql2);
		$iid = $con->insert_id;
		if ($resnum2)
			{
			$sql1 = "UPDATE `registration` SET `status`='$status' WHERE `user_id`='$iid'";
			$update = mysqli_query($con, $sql1);
			$sql = "SELECT * FROM `registration` WHERE `user_id` = '$iid'";
			$result1 = mysqli_query($con, $sql);
			$count = mysqli_num_rows($result1);
			$res = mysqli_fetch_assoc($result1);
			$result = array(
				"response" => array(
					'code' => '201',
					'message' => "Registration  successfully",
					'data' => $res
				)
			);
			print_r(json_encode($result));
			$sql1 = "UPDATE `registration` SET `status`='1' WHERE `user_id`='$iid'";
			$update = mysqli_query($con, $sql1);
			}
		  else
			{
			$result = array(
				"response" => array(
					'code' => '200',
					'message' => "Registration fail"
				)
			);
			print_r(json_encode($result));
			}
		}
	  else
		{
		$result = array(
			"response" => array(
				'code' => '200',
				'message' => "Email or Username Already Registered"
			)
		);
		print_r(json_encode($result));
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

?>