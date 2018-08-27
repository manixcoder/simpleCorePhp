 <?php
ob_start();
include ('config/config.php');

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
	$nickname = isset($_POST['nickname']) ? mysqli_real_escape_string($con, $_POST['nickname']) : "";
	$username = isset($_POST['username']) ? mysqli_real_escape_string($con, $_POST['username']) : "";
	$password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : "";
	$nationality = isset($_POST['nationality']) ? mysqli_real_escape_string($con, $_POST['nationality']) : "";
	$vocation = isset($_POST['vocation']) ? mysqli_real_escape_string($con, $_POST['vocation']) : "";
	$gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : "";
	$language = isset($_POST['language']) ? mysqli_real_escape_string($con, $_POST['language']) : "";
	$image = isset($_FILES['image']['name']) ? mysqli_real_escape_string($con, $_FILES['image']['name']) : "";
	$target_path = $target_path = "uploads/";
	$query = "INSERT into registration (`nickname`, `username`, `password`, `nationality`, `vocation`, `gender`, `language`, `profile_image`) VALUES ('$nickname', '$username', '$password', '$nationality', '$vocation', '$gender', '$language', '$image')";
	$up = move_uploaded_file($_FILES['image']['tmp_name'], $target_path . $_FILES['image']['name']);
	$insert = mysqli_query($con, $query);
	if ($insert)
		{
		if (!$up)
			{
			$data = array(
				"response" => array(
					'code' => '200',
					'message' => "Uploading Error!"
				)
			);
			print_r(json_encode($data));
			}
		  else
			{
			$data = array(
				"response" => array(
					'code' => '201',
					'message' => "User Registered  Successfully!"
				)
			);
			print_r(json_encode($data));
			}
		}
	  else
		{
		$data = array(
			"response" => array(
				'code' => '200',
				'message' => "Error!"
			)
		);
		print_r(json_encode($data));
		}
	}
  else
	{
	$data = array(
		"response" => array(
			'code' => '200',
			'message' => "Request method is wrong!!"
		)
	);
	print_r(json_encode($data));
	}

mysqli_close($con);
/* JSON Response */
header('Content-type: application/json');
?>