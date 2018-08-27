<?php
include ('config/config.php');

$user_id = $_POST['user_id'];
$nickname = $_POST['nickname'];
$nation_id = $_POST['nation_id'];
$vocation = $_POST['vocation'];
$gender = $_POST['gender'];
$language = $_POST['language'];
$date_birthday = $_POST['birthday'];
$image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
$query = "SELECT * FROM registration WHERE user_id ='$user_id'";
$resnum = mysqli_query($con, $query);
$res = mysqli_num_rows($resnum);
$row = mysqli_fetch_assoc($resnum);
$profile_image = $row['profile_image'];
$query1 = "SELECT * FROM `select_language` WHERE `language`='$language'";
$resnum1 = mysqli_query($con, $query1);
$row = mysqli_fetch_assoc($resnum1);
$l_code = $row['code'];

if ($image != '')
	{
	$file_path = "uploads/";
	$file_path = $file_path . basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
	if ($image != '')
		{
		$p_image = "asone_app/uploads/" . $image;
		}
	  else
		{
		$p_image = '';
		}
	}
	/*else{
	
			if($gender =="Male")
			{
				$p_image = "asone_app/profile_image/male.jpeg";
			}
			else
			{
				 $p_image = 'asone_app/profile_image/female.png';
			}
	
	}*/

if ($res == 1)
	{
	$sql = "SELECT `name`, `flag` FROM `nationality` WHERE `id`='$nation_id'";
	$resnum = mysqli_query($con, $sql);
	$result_arr = mysqli_fetch_assoc($resnum);
	$nationality_name = $result_arr['name'];
	$flag = $result_arr['flag'];
	$sql = "UPDATE `registration` SET `nickname`='$nickname',`nationality_id`='$nation_id',`nationality`='$nationality_name',`vocation`='$vocation',`gender`='$gender',`language`='$language',`l_code`='$l_code',`flag`='$flag',`profile_image`='$p_image',`date_birthday`='$date_birthday' WHERE `user_id`='$user_id'";
	$created_user = mysqli_query($con, $sql);
	if (!$created_user)
		{
		$result = array("response" => array('code' => '200','message' => "Query Failed")
		);
		print_r(json_encode($result));
		}
	  else
		{
		$sql = "SELECT * FROM `registration` WHERE `user_id` = '$user_id'";
		$result1 = mysqli_query($con, $sql);
		$count = mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		
		$result = array("response" => array('code' => '201','message' => "You have  Updated successfully your info. ",'data' => $res));
		print_r(json_encode($result));
		}
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => "Still did not update your detail !!"));
	print_r(json_encode($result));
	}
