<?php
include ('config/config.php');

if (isset($_REQUEST['prayer_id']) && !empty($_REQUEST['prayer_id']) && isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
	{
	$user_id = $_REQUEST['user_id'];
	$p_id = $_REQUEST['prayer_id'];
	$hh = "Likes Prayer";

	// $ht = "Likes Prayer";

	$sql = "SELECT `user_id` FROM `add_prayer` WHERE `pr_id`='$p_id'";
	$resnum = mysqli_query($con, $sql);
	$news_feed = mysqli_fetch_assoc($resnum);
	$feedowner_id = $news_feed['user_id'];
	$qry = "SELECT `user_id` FROM `prayer_like` WHERE `prayer_id`='$p_id' AND `user_id`='$user_id'";
	$resnum = mysqli_query($con, $qry);
	$res = mysqli_num_rows($resnum);
	if ($res == 0)
		{
		$qry = "SELECT `nickname`,`username`,`profile_image`,`flag` FROM registration WHERE user_id = '$user_id'";
		$resnum = mysqli_query($con, $qry);
		$res1 = mysqli_num_rows($resnum);
		while ($news_feed = mysqli_fetch_assoc($resnum))
			{
			$username = $news_feed['username'];
			$profile_image = $news_feed['profile_image'];
			$nickname = $news_feed['nickname'];
			$flag = $news_feed['flag'];
			}

		if ($res1 != 0)
			{
			$qry = "SELECT * FROM `add_prayer` WHERE pr_id = '$p_id'";
			$resnum = mysqli_query($con, $qry);
			$res = mysqli_num_rows($resnum);
			while ($news_feed1 = mysqli_fetch_assoc($resnum))
				{
				$prayer_content = mysqli_real_escape_string($con, $news_feed1['prayer_content']);
				$payer_image = $news_feed1['payer_image'];
				$likes = $news_feed1['likes'];
				$comments = $news_feed1['comments'];
				$gnews_id = $news_feed1['pr_id'];
				}

			if ($res != 0)
				{
				$sql = "INSERT INTO `prayer_like` ( `prayer_id`, `user_id`) VALUES ( '$p_id', '$user_id')";
				$results = mysqli_query($con, $sql);
				if ($results)
					{
					$sql = "SELECT `likes` FROM `add_prayer` WHERE `pr_id`='$p_id'";
					$rqty_result = mysqli_query($con, $sql);
					$gt_rqty = mysqli_fetch_assoc($rqty_result);
					$reserved_qty = $gt_rqty['likes'];
					$likes1 = $reserved_qty + 1;
					$update_qty = "UPDATE `add_prayer` SET `likes`='$likes1' WHERE `pr_id`='$p_id'";
					mysqli_query($con, $update_qty);
					$result = array(
						"response" => array(
							'code' => '201',
							'message' => "You have liked successfully.",
							'like' => $likes1
						)
					);
					print_r(json_encode($result));
					/* feed for Prayer like start*/
					$gg = "Posted Prayer";
					if ($feedowner_id == $user_id)
						{
						/*
						checking where user id and feedowner id is same  than update the number of likes
						*/
						$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$p_id' AND `feed_type`='$hh'";
						$run = mysqli_query($con, $sql);
						$res00 = mysqli_num_rows($run);
						$get_feed = mysqli_fetch_assoc($run);
						$feed_id = $get_feed['id'];
						$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$likes1' WHERE `id`='$feed_id'  AND `feed_type`='$hh'";
						$run = mysqli_query($con, $sql_update);
						}
					  else
						{
						$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$p_id' AND `feed_type`='$hh'";
						$run = mysqli_query($con, $sql);
						$res00 = mysqli_num_rows($run);
						$get_feed = mysqli_fetch_assoc($run);
						$feed_id = $get_feed['id'];
						if ($res00 == 0)
							{
							$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`content`,`content_image`, `post_id`, `feed_type`,`no_of_likes`,`no_of_comments`) 
      VALUES ('$feedowner_id','$user_id','$prayer_content','$payer_image','$p_id','$hh','$likes1','$comments')";
							$run = mysqli_query($con, $sql_feed);
							}
						  else
							{
							$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$likes1' WHERE `id`='$feed_id' AND `feed_type`='$hh' ";
							$run = mysqli_query($con, $sql_update);
							}
						}

					// Push notification start

					$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' AND `push_res`='1'";
					$resnum = mysqli_query($con, $sql);
					$res = mysqli_num_rows($resnum);
					$news_feed = mysqli_fetch_assoc($resnum);
					$dd = $news_feed['device_type'];
					$deviceToken1 = $news_feed['device_id'];
					if ($dd)
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
						$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id'";
						$resnum = mysqli_query($con, $sql);
						$res = mysqli_num_rows($resnum);
						$news_feed = mysqli_fetch_assoc($resnum);
						$dd = $news_feed['device_type'];
						$deviceToken1 = $news_feed['device_id'];
						$deviceToken = $deviceToken1;

						// Put your private key's passphrase here:

						$passphrase = 'ASone';

						
						// Put your alert message here:
						

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

					/*   feed for Prayer like end*/
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
					{
					$result = array(
						"response" => array(
							'code' => '200',
							'message' => "Prayer Not found"
						)
					);
					print_r(json_encode($result));
					}
				}
			}
		  else
			{
			$result = array(
				"response" => array(
					'code' => '200',
					'message' => "User Not found"
				)
			);
			print_r(json_encode($result));
			}
		}
	  else
	/*         Dislike start  */
		{
		$qry = "SELECT * FROM `add_prayer` WHERE pr_id = '$p_id'";
		$resnum = mysqli_query($con, $qry);
		$res = mysqli_num_rows($resnum);
		while ($news_feed1 = mysqli_fetch_assoc($resnum))
			{
			$prayer_content = $news_feed1['prayer_content'];
			$payer_image = $news_feed1['payer_image'];
			$likes = $news_feed1['likes'];
			$comments = $news_feed1['comments'];
			$gnews_id = $news_feed1['pr_id'];
			}

		$sql = "DELETE FROM `prayer_like` WHERE `prayer_id`='$p_id' AND `user_id`='$user_id'";
		$result = mysqli_query($con, $sql);
		if ($result)
			{
			$sql = "SELECT  `likes` FROM `add_prayer` WHERE `pr_id`='$p_id'";
			$resnum = mysqli_query($con, $sql);
			$news_feed = mysqli_fetch_assoc($resnum);
			$likes = $news_feed['likes'];
			$li = $likes - 1;
			$result = array(
				"response" => array(
					'code' => '201',
					'message' => "You have dislike the Prayer",
					'like' => $li
				)
			);
			print_r(json_encode($result));
			$sql = "SELECT `likes` FROM `add_prayer` WHERE `pr_id`='$p_id'";
			$rqty_result = mysqli_query($con, $sql);
			$gt_rqty = mysqli_fetch_assoc($rqty_result);
			$reserved_qty = $gt_rqty['likes'];
			$f_qty = $reserved_qty - 1;
			$update_qty = "UPDATE `add_prayer` SET `likes`='$f_qty' WHERE `pr_id`='$p_id'";
			mysqli_query($con, $update_qty);
			/* for feed add */
			$gg = "Posted Prayer";
			$sql = "SELECT `user_id` FROM `add_prayer` WHERE `pr_id`='$p_id'";
			$resnum = mysqli_query($con, $sql);
			while ($news_feed = mysqli_fetch_assoc($resnum))
				{
				$feedowner_id = $news_feed['user_id'];
				}

			if ($feedowner_id == $user_id)
				{
				$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$f_qty' WHERE `id`='$feed_id'";
				$run = mysqli_query($con, $sql_update);
				}
			  else
				{
				$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$p_id' AND `feed_type`='$hh'";
				$run = mysqli_query($con, $sql);
				$res00 = mysqli_num_rows($run);
				$get_feed = mysqli_fetch_assoc($run);
				$feed_id = $get_feed['id'];
				if ($res00 == 0)
					{
					$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`content`,`content_image`, `post_id`, `feed_type`,`no_of_likes`,`no_of_comments`) 
      VALUES ('$feedowner_id','$user_id','$prayer_content','$payer_image','$p_id','$hh','$likes','$comments')";
					$run = mysqli_query($con, $sql_feed);
					}
				  else
					{
					$sql_update = "UPDATE `feeds_m` SET `action_owner_id`='$user_id',`no_of_likes`='$f_qty' WHERE `id`='$feed_id'";
					$run = mysqli_query($con, $sql_update);
					}
				}

			/*   feed end*/

			// Push notification start

			$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id' AND `push_res`='1'";
			$resnum = mysqli_query($con, $sql);
			$res = mysqli_num_rows($resnum);
			$news_feed = mysqli_fetch_assoc($resnum);
			$dd = $news_feed['device_type'];
			$deviceToken1 = $news_feed['device_id'];
			if ($dd)
				{

	

				$deviceToken = $deviceToken1;

				// Put your private key's passphrase here:
			

				$passphrase = $hh;

				// Put your alert message here:

				$message = 'Prayer Unlike!';

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

				

				$body['aps'] = array(
					"content-available" => 'prayer_unlike',
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
				$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id'";
				$resnum = mysqli_query($con, $sql);
				$res = mysqli_num_rows($resnum);
				$news_feed = mysqli_fetch_assoc($resnum);
				$deviceToken1 = $news_feed['device_id'];


				$deviceToken = $deviceToken1;

				// Put your private key's passphrase here:
				// $passphrase = 'ASone';

				$passphrase = $hh;

				// Put your alert message here:

				$message = 'Prayer Unlike!';

			
				// //////////////////////////////////////////////////////////////////////////////

				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

				// Open a connection to the APNS server

				$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
				if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
				$ff = 'Connected to APNS' . PHP_EOL;

				
				// Create the payload body

				$body['aps'] = array(
					"content-available" => 'prayer_unlike',
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
