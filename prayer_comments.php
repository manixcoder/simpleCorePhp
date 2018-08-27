<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) 
&& isset($_REQUEST['prayer_id']) && !empty($_REQUEST['prayer_id']) 
&& isset($_REQUEST['comment']) && !empty($_REQUEST['comment']))
	{
	$user_id = $_REQUEST['user_id'];
	$prayer_id = $_REQUEST['prayer_id'];
	$comment1 = $_REQUEST['comment'];
	$comment = mysqli_real_escape_string($con, $comment1);
	$hh = 'Prayer Comments';
	$ht = 'Prayer_comments';
	$hh1 = "Commented on your Prayer";
	$sql_un = "SELECT * FROM `add_prayer` WHERE `pr_id`='$prayer_id'";
	$sa = mysqli_query($con, $sql_un);
	$count = mysqli_num_rows($sa);
	while ($news_feed = mysqli_fetch_assoc($sa))
		{
		$feedowner_id = $news_feed['user_id'];
		$comments = $news_feed['comments'];
		$likes = $news_feed['likes'];
		$prayer_content = mysqli_real_escape_string($con, $news_feed['prayer_content']);
		$payer_image = $news_feed['payer_image'];
		}

	if ($count == 1)
		{
		$query_following_u_Id = "SELECT *  FROM registration WHERE  user_id ='$user_id'";
		$resnum_following_u_Id = mysqli_query($con, $query_following_u_Id);
		$res_following_u_Id = mysqli_num_rows($resnum_following_u_Id);
		while ($news_feed = mysqli_fetch_assoc($resnum_following_u_Id))
			{
			$Name = $news_feed['username'];
			$profile_image1 = $news_feed['profile_image'];
			$vocation1 = $news_feed['vocation'];
			$flag = $news_feed['flag'];
			$nickname = $news_feed['nickname'];
			}

		if ($res_following_u_Id == TRUE)
			{
			$query_create_user = "INSERT INTO `prayer_comment` (`user_id`, `prayer_id`, `comment`) 
     		       	     VALUES ('$user_id', '$prayer_id', '$comment')";
			$created_user = mysqli_query($con, $query_create_user);
			$iid = $con->insert_id;
			if (!$created_user)
				{
				$result = array(
					"response" => array(
						'code' => '200',
						'message' => "Query Failed"
					)
				);
				print_r(json_encode($result));
				}

			if (mysqli_affected_rows($con) == 1)
				{
				$ss = "Update add_prayer set comments=comments+1 where pr_id='$prayer_id'";
				$unc = mysqli_query($con, $ss);
				$com = $comments + 1;
				$data2 = array(
					'comments' => $com,
					'id' => $iid
				);
				$result = array(
					"response" => array(
						'code' => '201',
						'message' => "You have Succesfully comment on the Prayer.",
						'data' => $data2
					)
				);
				print_r(json_encode($result));
				/* for feed add */
				if ($feedowner_id == $user_id)
					{
					}
				  else
					{
					$sql = "SELECT * FROM `feeds_m` WHERE `feedowner_id`='$feedowner_id' AND `action_owner_id`='$user_id' AND `feed_type`='$hh'";
					$run = mysqli_query($con, $sql);
					$res00 = mysqli_num_rows($run);
					$get_feed = mysqli_fetch_assoc($run);
					$feed_id = $get_feed['id'];
					if ($res00 == 0)
						{
						$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`, `post_id`,`content`,`content_image`, `feed_type`,`no_of_comments`)
				  VALUES ('$feedowner_id','$user_id','$prayer_id','$prayer_content','$payer_image','$hh','$com')";
						$run = mysqli_query($con, $sql_feed);
						}
					  else
						{
						$sql = "UPDATE `feeds_m` SET `no_of_likes`='$likes',`no_of_comments`='$com' WHERE `id`='$feed_id'";
						$run = mysqli_query($con, $sql);
						}

					// Push notification start

					$sql = "SELECT * FROM `registration` WHERE `user_id`='$feedowner_id'";
					$resnum = mysqli_query($con, $sql);
					$res = mysqli_num_rows($resnum);
					$news_feed = mysqli_fetch_assoc($resnum);
					$dd = $news_feed['device_type'];
					$deviceToken1 = $news_feed['device_id'];
					if ($dd == 2)
						{
						$deviceToken = $deviceToken1;
						// Put your private key's passphrase here:
						// $passphrase = 'ASone';
						$passphrase = $hh;
						// Put your alert message here:	
						$message = $nickname . " " . $hh1;
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
						fclose($fp);
						}
					// Push notification end
					}

				/*  feed */
				}
			  else
				{
				$result = array(
					"response" => array(
						'code' => '200',
						'message' => "You could not be registered due to a system error"
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
					'message' => "User Id not Exists "
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
				'message' => "Prayer Not exists."
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
