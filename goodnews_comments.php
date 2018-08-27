<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) 
&& isset($_REQUEST['gnews_id']) && !empty($_REQUEST['gnews_id']) 
&& isset($_REQUEST['comment']) && !empty($_REQUEST['comment']))
	{
	$user_id = $_REQUEST['user_id'];
	$gnews_id = $_REQUEST['gnews_id'];
	$comment1 = $_REQUEST['comment'];
	
	$comment = mysqli_real_escape_string($con, $comment1);
	$hh = "Good news Comment";
	$hh1 = "Commented on your Good news";
	$ht = "Good news Comments";
	$sql_un = "SELECT * FROM `goodnews` WHERE `gnews_id`='$gnews_id'";
	$sa = mysqli_query($con, $sql_un);
	$count = mysqli_num_rows($sa);
	while ($news_feed2 = mysqli_fetch_assoc($sa))
		{
		$gnews_content = mysqli_real_escape_string($con, $news_feed2['gnews_content']);
		$gnews_image = $news_feed2['gnews_image'];
		$feedowner_id = $news_feed2['user_id'];
		$comments = $news_feed2['comments'];
		$likes = $news_feed2['likes'];
		}
	if ($count == 1)
		{
		$query_following_u_Id = "SELECT * FROM registration WHERE  user_id ='$user_id'";
		$resnum_following_u_Id = mysqli_query($con, $query_following_u_Id);
		$res_following_u_Id = mysqli_num_rows($resnum_following_u_Id);
		
		while ($news_feed = mysqli_fetch_assoc($resnum_following_u_Id))
			{
				$Name = $news_feed['username'];
				$profile_image1 = $news_feed['profile_image'];
				$vocation1 = $news_feed['vocation'];
				$nickname = $news_feed['nickname'];
				$flag = $news_feed['flag'];
			}
		if ($res_following_u_Id == TRUE)
			{
			$query_create_user = "INSERT INTO `gnews_comment` (`user_id`,  `gnews_id`, `comment`) 
	                     VALUES ('$user_id','$gnews_id', '$comment')";
			$created_user = mysqli_query($con, $query_create_user);			
			$com_id = $con->insert_id;
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
				$unc = mysqli_query($con, "Update goodnews set comments=comments+1 where gnews_id='$gnews_id'");
				$coo = $comments + 1;
				$data2 = array(
					'comments' => $coo,
					'id' => $com_id
				);
				$result = array(
					"response" => array(
						'code' => '201',
						'message' => "You have successfull commented.",
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
					$sql = "SELECT * FROM `feeds_m` WHERE `post_id` ='$gnews_id' AND `feed_type`='$hh'";
					$run = mysqli_query($con, $sql);
					$res00 = mysqli_num_rows($run);
					$get_feed = mysqli_fetch_assoc($run);
					$feed_id = $get_feed['id'];
					$commmm = $comments + 1;
					if ($res00 == 0)
						{							
							$sql_feed = "INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`, `post_id`,`content`,`content_image`,`comments`, `feed_type`,`no_of_comments`,`no_of_likes`) 
	       			 VALUES ('$feedowner_id','$user_id','$gnews_id','$gnews_content','$gnews_image','$comment','$hh','$commmm','$likes')";
							$run = mysqli_query($con, $sql_feed);
						}
					  else
						{
							$sql = "UPDATE `feeds_m` SET `no_of_likes`='$likes',`no_of_comments`='$coo' WHERE `id`='$feed_id'";
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
							// Put your alert message here:					
							$message = $nickname . " " . $hh1;
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

				/*   feed */
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
				'message' => "goodnews Not exists."
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
			'message' => "Data not Available"
		)
	);
	print_r(json_encode($result));
	}
