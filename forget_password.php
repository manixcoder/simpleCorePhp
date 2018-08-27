<?php
include ("config/config.php");

if (isset($_REQUEST['email']))
	{
	$email = $_REQUEST['email'];
	$code = $_GET['password'];
	$sql = "select * from registration where `username`='$email'";
	$query = mysqli_query($con, $sql) or die(mysqli_error($con));
	if (mysqli_num_rows($query) == 1)
		{
		$acceptablePasswordChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_.$@#&0123456789";
		$randomPassword = "";
		for ($i = 0; $i < 5; $i++)
			{

			// for generate password

			$randomPassword.= substr($acceptablePasswordChars, rand(0, strlen($acceptablePasswordChars) - 1) , 1);
			}

		$headers = "From: " . $email . " \r\n";
		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$code = $randomPassword;
		$message = "You Website link is: http://www.a1professionals.net/asone_app/ Email : " . $email . "  Newpassword : " . $code . "";
		@mail($email, "Change Password", $message, $headers);

		// $result = array("success"=>'true','message'=>"Password has been sent to your e-mail address ");
		// print_r(json_encode($result));

		$result = array(
			"response" => array(
				'code' => '201',
				'message' => "Password has been sent to your e-mail address"
			)
		);
		print_r(json_encode($result));
		$sql = "UPDATE `registration` SET `password`='$code' WHERE `username`='$email'";

		

		$query2 = mysqli_query($con, $sql) or die(mysqli_error($con));
		}
	  else
		{
		$result = array(
			"response" => array(
				'code' => '200',
				'message' => "No user exist with this email id"
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
			'message' => "No Data Available"
		)
	);
	print_r(json_encode($result));
	}

?>