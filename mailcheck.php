<?php
include ("config/config.php");

if (isset($_REQUEST['email']))
	{
	$email = $_REQUEST['email'];
	$code = '123';
	
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
		$message = '<html>
				<body style="background-color:#F4F4F4;">
				<table style="max-width:500px;min-width:500px;margin:0 auto;background-color:#fff;text-align:center;">
				<tr>
				<td style="color:#696969;font-family:open sans;font-size:14px;padding:7px 0;text-align:left;
				padding-left:20px;padding-right:20px;padding-top:40px;">
				Hi Hello
				</td>
				</tr>
				<tr>
				<td style="color:#696969;font-family:open sans;font-size:14px;padding:7px 0;
				text-align:left;padding-left:20px;padding-right:20px;line-height:24px;">
				You have requested the new password. Please enter the following OTP to reset password.
				</td>
				</tr>
				<tr>
				<td style="color:#696969;font-family:open sans;font-size:14px;padding:30px 0;
				text-align:left;padding-left:20px;padding-right:20px;">
				Please use this password for login: ' . $code . '
				</td>
				</tr>
				<tr>
				<td style="color:#696969;font-family:open sans;font-size:14px;padding:0;
				text-align:left;padding-left:20px;padding-right:20px;">
				Regards
				</td>
				</tr>
				<tr>
				<td style="color:#23A8E0;font-family:open sans;font-size:14px;padding:0;
				text-align:left;padding-left:20px;padding-right:20px;padding-bottom:40px;">
				Army App
				</td>
				</tr>
				</table>
				</body>
				</html>';
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