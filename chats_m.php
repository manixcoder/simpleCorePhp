<?php
include ('config/config.php');
if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) 
&& isset($_REQUEST['opp_id']) && !empty($_REQUEST['opp_id']) 
&& isset($_REQUEST['s_msg']) && !empty($_REQUEST['s_msg']))
	{
	$user_id = $_REQUEST['user_id'];
	$f_id = $_REQUEST['opp_id'];
	$s_msg = $_REQUEST['s_msg'];
	$sql = "SELECT nickname FROM registration WHERE user_id='$user_id'";
	$result = mysqli_query($con, $sql);
	$count = mysqli_num_rows($result);
	$news_feed = mysqli_fetch_assoc($result);
	$name = $news_feed['nickname'];
	if ($count > 0)
		{
		$sql1 = "SELECT * FROM `registration` WHERE user_id=$f_id";
		$result1 = mysqli_query($con, $sql1);
		$count1 = mysqli_num_rows($result1);
		$news_feed1 = mysqli_fetch_assoc($result1);
		$device_id = $news_feed1['device_id'];
		$push_on_off = $news_feed1['push_res'];
		$device_type = $news_feed1['device_type'];
		if ($count1 > 0)
			{
			$sqll = "SELECT * FROM recent_chat  where user_id='$user_id' AND opp_id='$f_id' OR user_id='$f_id' AND opp_id='$user_id' ";
			$ex_sql = mysqli_query($con, $sqll);
			$row = mysqli_num_rows($ex_sql);
			$fetch = mysqli_fetch_assoc($ex_sql);
			$id = $fetch['id'];
			if ($row > 0)
				{
					$sql_u = "UPDATE `recent_chat` SET `user_id`='$user_id',`opp_id`='$f_id',`s_msg`='$s_msg'  WHERE `id`='$id'";
					mysqli_query($con, $sql_u);
				}
			  else
				{
					$sql_ii = "INSERT INTO recent_chat (`user_id`, `opp_id`, `s_msg`) VALUES ('$user_id','$f_id','$s_msg')";
					$ex_ii = mysqli_query($con, $sql_ii);
				}


			$sql2 = "INSERT INTO `chats`( `user_id`, `opp_id`,  `s_msg`)  VALUES ('$user_id','$f_id','$s_msg')";
			$result2 = mysqli_query($con, $sql2);
			if ($result2)
				{
				// /////////////
				$message = $name . " Send You message " . $s_msg;
				if ($device_type == '2')
					{
					$deviceToken = $device_id;
					if ($push_on_off == '1')
						{
							// Put your alert message here:					
							$message = $name . " Send You message " . $s_msg;
							// //////////////////////////////////////////////////////////////////////////////
							$ctx = stream_context_create();
							stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
							stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
							// Open a connection to the APNS server
							// Production:
	
							$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
	
							// Development:
							// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
	
							if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
							$ff = 'Connected to APNS' . PHP_EOL;
							// Create the payload body
							$body['aps'] = array(
								'alert' => $message,
								'sound' => 'default'
							);	
							// Encode the payload as JSON	
							$payload = json_encode($body);
							$ddd = json_decode($payload);	
							// Build the binary notification	
							$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
							// Send it to the server
	
							$result = fwrite($fp, $msg, strlen($msg));
							if (!$result) $jh = 'Message not delivered' . PHP_EOL;
							  else $jh = 'Message successfully delivered' . PHP_EOL;
							fclose($fp);
						}
					  else
						{
						// ////////////////////
						$message = $name . " Send You message " . $s_msg;
						
						$ctx = stream_context_create();
						stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
						stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
						// Open a connection to the APNS server
						// Production:

						$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

						// Development:
						//  $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

						if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
						$ff = 'Connected to APNS' . PHP_EOL;					
						// Create the payload body

						$body['aps'] = array(
							"content-available" => 'Chat',
							'sound' => 'default'
						);
						$payload = json_encode($body);
						$ddd = json_decode($payload);
						// Build the binary notification
						$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
						// Send it to the server
						$result = fwrite($fp, $msg, strlen($msg));
						if (!$result) $jh = 'Message not delivered' . PHP_EOL;
						  else $jh = 'Message successfully delivered' . PHP_EOL;
						fclose($fp);
						}
					}
				  else
					{
						$message = $message;
						$regId = $device_id;
						include_once ('gcm.php');
	
						$gcm = new GCM();
						$registatoin_ids = array(
							$regId
						);
						$message = array(
							"price" => $message
						);
						$result = $gcm->send_notification($registatoin_ids, $message);
						$dd = json_decode($result);
					}

				$result = array(
					"response" => array(
						'code' => '201',
						'message' => "Massages send successfully"
					)
				);
				print_r(json_encode($result));
				}
			  else
				{
				$result = array(
					"response" => array(
						'code' => '200',
						'message' => "Query fails"
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
					'message' => "Freind Id not found"
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
				'message' => "User Id not found"
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
