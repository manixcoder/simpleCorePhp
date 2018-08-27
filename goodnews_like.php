<?php
include ('config/config.php');
if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) 
&& isset($_REQUEST['gnews_id']) && !empty($_REQUEST['gnews_id']))
	{
	$user_id = $_REQUEST['user_id'];
	$gnews_id = $_REQUEST['gnews_id'];
	$hh = "likes Good News";
	$ht = "likes Good News";
	$qry = "SELECT * FROM `goodnews_like` WHERE `gnews_id`='$gnews_id' AND `user_id`='$user_id'";
	$resnum = mysqli_query($con, $qry);
	$res = mysqli_num_rows($resnum);
	if ($res == 0)
		{
		$qry = "SELECT *  FROM registration WHERE user_id = '$user_id'";
		$resnum = mysqli_query($con, $qry);
		$res = mysqli_num_rows($resnum);
		$gg = mysqli_fetch_assoc($resnum);
		$nickname = $gg['nickname'];
		if ($res == 1)
			{
			$qry = "SELECT * FROM `goodnews` WHERE `gnews_id` = '$gnews_id'";
			$resnum1 = mysqli_query($con, $qry);
			$res1 = mysqli_num_rows($resnum1);
			$news_feed1 = mysqli_fetch_assoc($resnum1);
			$likes = $news_feed1['likes'];
			$feedowner_id = $news_feed1['user_id'];
			$gnews_content = $news_feed1['gnews_content'];
			$gnews_image = $news_feed1['gnews_image'];
			$comments = $news_feed1['comments'];
			$likes = $news_feed1['likes'];
			if ($res1 == 1)
				{
				$sql = "INSERT INTO `goodnews_like` ( `gnews_id`, `user_id`)
				VALUES ( '$gnews_id', '$user_id')";
				$results = mysqli_query($con, $sql);
				if ($results)
					{
					$likes1 = $likes + 1;
					$result = array(
						"response" => array(
							'code' => '201',
							'message' => "You have liked Successfully.",
							'like' => $likes1
						)
					);
					print_r(json_encode($result));
					/* for feed add */
					$gg = "Posted Good News";
					if ($feedowner_id == $user_id)
						{
						}
					  else
						{

						// /////////

						$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$gnews_id' AND `feed_type`='$hh' ";
						$run = mysqli_query($con, $sql);
						$res00 = mysqli_num_rows($run);
						$get_feed = mysqli_fetch_assoc($run);
						$feed_id = $get_feed['id'];
						if ($res00 == 0)
							{
							$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`content`,`content_image`, `post_id`, `feed_type`,`no_of_likes`,`no_of_comments`) 
 VALUES ('$feedowner_id','$user_id','$gnews_content','$gnews_image','$gnews_id','$hh','$likes1','$comments')";
							$run = mysqli_query($con, $sql_feed);
							}
						  else
							{
							$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$likes1' WHERE `id`='$feed_id' AND `feed_type`='$hh'";
							$run = mysqli_query($con, $sql_update);
							}

						// Push notification start

						$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' AND `push_res`='1'";
						$resnum = mysqli_query($con, $sql);
						$res = mysqli_num_rows($resnum);
						$news_feed = mysqli_fetch_assoc($resnum);
						$dd = $news_feed['device_type'];
						$deviceToken1 = $news_feed['device_id'];
						if ($dd == 2)
							{
							$deviceToken = $deviceToken1;
							// Put your private key's passphrase here:
							$passphrase = 'ASone';
							$message = $nickname . " " . $hh;
							// //////////////////////////////////////////////////////////////////////////////

							$ctx = stream_context_create();
							stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
							stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

							// Open a connection to the APNS server
							// Production:

							$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

							// Development:
							// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

							if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
							$ff = 'Connected to APNS' . PHP_EOL;

							// Create the payload body

							$body['aps'] = array(
								'alert' => $message,
								'sound' => 'default'
							);
							// Encode the payload as JSON
							$payload = json_encode($body);
							$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

							// Send it to the server

							$result = fwrite($fp, $msg, strlen($msg));
							if (!$result) $jh = 'Message not delivered' . PHP_EOL;
							  else $jh = 'Message successfully delivered' . PHP_EOL;

							// Close the connection to the server

							fclose($fp);
							}
						  else
							{
							$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' ";
							$resnum = mysqli_query($con, $sql);
							$res = mysqli_num_rows($resnum);
							$news_feed = mysqli_fetch_assoc($resnum);
							$dd = $news_feed['device_type'];
							$deviceToken1 = $news_feed['device_id'];
						
							$deviceToken = $deviceToken1;

							// Put your private key's passphrase here:

							$passphrase = 'ASone';

							// Put your alert message here:

							$message = 'goodnews_like!';

							// //////////////////////////////////////////////////////////////////////////////

							$ctx = stream_context_create();
							stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
							stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

							// Open a connection to the APNS server
							// Production:

							$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

							// Development:
							// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

							if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
							$ff = 'Connected to APNS' . PHP_EOL;

							// echo 'Connected to APNS' . PHP_EOL;
							// Create the payload body

							$body['aps'] = array(
								"content-available" => 'goodnews_unlike',
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

							// Close the connection to the server

							fclose($fp);
							}

						// Push notification end

						}

					/*   feed */
					$sql = "SELECT `likes` FROM `goodnews` WHERE `gnews_id`='$gnews_id'";
					$rqty_result = mysqli_query($con, $sql);
					$gt_rqty = mysqli_fetch_assoc($rqty_result);
					$reserved_qty = $gt_rqty['likes'];
					$f_qty = $reserved_qty + 1;
					$update_qty = "UPDATE `goodnews` SET `likes`='$f_qty' WHERE `gnews_id`='$gnews_id'";
					mysqli_query($con, $update_qty);
					}
				  else
					{
					$result = array(
						"response" => array(
							'code' => '200',
							'message' => "Query Failed"
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
						'message' => "News not found"
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
					'message' => "User not found"
				)
			);
			print_r(json_encode($result));
			}
		}
	  else
		{
		$sql = "DELETE FROM `goodnews_like` WHERE `gnews_id`='$gnews_id' AND `user_id`='$user_id'";
		$result = mysqli_query($con, $sql);
		if ($result)
			{
			$sql = "SELECT `likes` FROM `goodnews` WHERE `gnews_id`='$gnews_id'";
			$rqty_result = mysqli_query($con, $sql);
			$gt_rqty = mysqli_fetch_assoc($rqty_result);
			$reserved_qty = $gt_rqty['likes'];
			$f_qty = $reserved_qty - 1;
			$sql = "UPDATE `goodnews` SET `likes`='$f_qty' WHERE `gnews_id`='$gnews_id'";
			$rqty_result = mysqli_query($con, $sql);
			/* for feed add */
			$qry = "SELECT * FROM `goodnews` WHERE `gnews_id` = '$gnews_id'";
			$resnum1 = mysqli_query($con, $qry);
			$res1 = mysqli_num_rows($resnum1);
			$news_feed1 = mysqli_fetch_assoc($resnum1);
			$likes = $news_feed1['likes'];
			$feedowner_id = $news_feed1['user_id'];
			$gnews_content = mysqli_real_escape_string($con, $news_feed1['gnews_content']);
			$gnews_image = $news_feed1['gnews_image'];
			$comments = $news_feed1['comments'];
			if ($feedowner_id == $user_id)
				{
				}
			  else
				{
				$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$gnews_id' AND `feed_type`='$hh'";
				$run = mysqli_query($con, $sql);
				$res00 = mysqli_num_rows($run);
				$get_feed = mysqli_fetch_assoc($run);
				$feed_id = $get_feed['id'];
				if ($res00 != 0)
					{
					$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$likes' WHERE `id`='$feed_id'";
					$run = mysqli_query($con, $sql_update);
					}
				  else
					{
					$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`content`,`content_image`, `post_id`, `feed_type`,`no_of_likes`,`no_of_comments`) 
 VALUES ('$feedowner_id','$user_id','$gnews_content','$gnews_image','$gnews_id','$hh','$likes1','$comments')";
					$run = mysqli_query($con, $sql_feed);
					}
				}

			/*   feed */
			$qry1 = "SELECT `likes` FROM `goodnews` WHERE `gnews_id` = '$gnews_id'";
			$resnum11 = mysqli_query($con, $qry1);
			$res1 = mysqli_num_rows($resnum1);
			$news_feed11 = mysqli_fetch_assoc($resnum11);
			$likes = $news_feed11['likes'];
			$result = array(
				"response" => array(
					'code' => '201',
					'message' => "You have dislike Successfully",
					'like' => $likes
				)
			);
			print_r(json_encode($result));

			// Push notification start

			$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' AND `push_res`='1'";
			$resnum = mysqli_query($con, $sql);
			$res = mysqli_num_rows($resnum);
			$news_feed = mysqli_fetch_assoc($resnum);
			$dd = $news_feed['device_type'];
			$deviceToken1 = $news_feed['device_id'];
			if ($dd == 2)
				{
				$deviceToken = $deviceToken1;
				// Put your private key's passphrase here:	
				$passphrase = $hh;
				// Put your alert message here:
				$message = 'goodnews_like_Unlike!';
				// $message = $nickname." ".$hh ;
				// //////////////////////////////////////////////////////////////////////////////
				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
				// Open a connection to the APNS server
				// Production:
				$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
				// Development:
				// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
				$ff = 'Connected to APNS' . PHP_EOL;

				// echo 'Connected to APNS' . PHP_EOL;
				// Create the payload body

				$body['aps'] = array(
					"content-available" => 'goodnews_unlike',
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

				// Close the connection to the server

				fclose($fp);
				}
			  else
				{
				$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' ";
				$resnum = mysqli_query($con, $sql);
				$res = mysqli_num_rows($resnum);
				$news_feed = mysqli_fetch_assoc($resnum);
				$dd = $news_feed['device_type'];
				$deviceToken1 = $news_feed['device_id'];
				$deviceToken = $deviceToken1;
				// Put your private key's passphrase here:
				$passphrase = 'ASone';
				// Put your alert message here:
				$message = 'goodnews_like_Unlike!';
				// //////////////////////////////////////////////////////////////////////////////
				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

				// Open a connection to the APNS server
				// Production:

				$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

				// Development:
				// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

				if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
				$ff = 'Connected to APNS' . PHP_EOL;

				// echo 'Connected to APNS' . PHP_EOL;
				// Create the payload body

				$body['aps'] = array(
					"content-available" => 'goodnews_unlike',
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

				// Close the connection to the server

				fclose($fp);
				}

			// Push notification end

			}
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
