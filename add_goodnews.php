 <?php
include("config/config.php");
$user_id = $_POST['user_id'];

$content1     = isset($_POST['gnews_content']) ? $_POST['gnews_content'] : '';
$gnews_image1 = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
//$content      = preg_replace('/[^A-Za-z0-9\-\']/', '', $content1);
$content = mysqli_real_escape_string($con,$content1);

$date_tine = $_POST['datetime'];

$type         = 'Posted Good News';
/*
$date = new DateTime(date());
$date->setTime(14, 55, 24);
$time = $date->format('Y-m-d H:i:s');*/

$qry    = "SELECT * FROM registration WHERE user_id = '$user_id'";
$resnum = mysqli_query($con, $qry);
$res    = mysqli_num_rows($resnum);
 $res1     = mysqli_fetch_assoc($resnum);
 $nickname = $res1['nickname'];


if ($res == 1) {
    
    if ($gnews_image1 != '') {
        $file_path = "uploads/";
        $file_path = $file_path . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
        if ($gnews_image1 != '') {
            
           // $gnews_image1 = BASE_URL . "asone_app/uploads/" . $gnews_image1;
              $gnews_image1 ="asone_app/uploads/". $gnews_image1;
        }
         else 
         {
            $gnews_image1 = '';
        }
    }
    
    

    
    $sql     = "INSERT INTO `goodnews` (`user_id`,  `gnews_content`, `gnews_image`,`datetime`) " . "VALUES ( '$user_id','$content', '$gnews_image1','$date_tine')";
    $results = mysqli_query($con, $sql);
    $last_id = $con->insert_id;
    
    if ($results) {
        
        /* for feed */
        $sql_f   = "SELECT `followers` FROM `followers_by_uid` WHERE `user_id`='$user_id'";
        $resnum2 = mysqli_query($con, $sql_f);
       
        $r_f     = array();
        while ($result_arr_g = mysqli_fetch_assoc($resnum2)) {
            if ($result_arr_g) {
                array_push($r_f, $result_arr_g);
            }
        }
        
        foreach ($r_f as $ff) {
           $follower_id   = $ff['followers'];
            $foll_goodnews = "SELECT `user_id` FROM `registration` WHERE `user_id` = '$follower_id'";
            $resnum_g      = mysqli_query($con, $foll_goodnews);
            $r             = array();
            while ($result_arr_g = mysqli_fetch_assoc($resnum_g)) {
                if ($result_arr_g) {
                    array_push($r, $result_arr_g);
                }
                
            }
       
            $user_get_feed = $r[0]['user_id'];
            
            $sql_for_feed = "INSERT INTO `feeds_m`( `feedowner_id`,`action_owner_id`, `post_id`, `content`, `content_image`, `feed_type`) 
           VALUES ('$user_get_feed','$user_id','$last_id','$content','$gnews_image1','$type')";
            $resnum_g     = mysqli_query($con, $sql_for_feed);
            
                       
            						
//Push notification start 
							
					
 $sql="SELECT * FROM `registration` WHERE `user_id`='$user_get_feed'";
 $resnum = mysqli_query($con, $sql);
 $res = mysqli_num_rows($resnum);
 $news_feed=mysqli_fetch_assoc($resnum);
 $dd= $news_feed['device_type'];
 $deviceToken1= $news_feed['device_id'];
 if($dd ==2)
 { 

$deviceToken = $deviceToken1;

// Put your alert message here:
//$message = 'My first push notification!';
$message = $nickname." ".$type;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
//Production:
$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
//Development:
//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

 $ff='Connected to APNS' . PHP_EOL;
//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);
$ddd= json_decode($payload);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));



if (!$result)
	$jh= 'Message not delivered' . PHP_EOL;
else
	 $jh='Message successfully delivered' . PHP_EOL;
	 
	//$data2 = array('Push_data' =>$ddd, 'You have liked successfully.' =>$likes1);
	//$result1 = array("response"=>array('code'=>'201','message'=>" Push Notification send  !!.",'data'=>$ddd));
	//$result1 = array("response"=>array('code'=>'201','message'=>" Push Notification send  !!.",'data'=>$data2));
     // print_r(json_encode($result1));

// Close the connection to the server
fclose($fp);
}
else 
{
	
//  $regId = "APA91bH-cXh9WaHQ6zc7Y4QAIaViw_99rFqRV0NSRp98VIct3sBWyKlOwCwQmXJvqHa2bcMEdV0TjfCGhj_SKo-gXokY_3ZG9udYkTY4ygSunz38lAAc7N0mamWnLSUYYQJo9y9Kyh5E";
 //$regId = "APA91bGdkFTlqEQYAp56fwQwtKsvhx-bfs1UWLH2_9FjRkE7kcJBkUivs0GlugVD5PGrvujyVjsL_FyIkM6btPYok0JDWkxq-NsLW6ry4sO-jvRTgDyvl8Y";
 $regId =$deviceToken1;

    $message = $message;
     
    include('gcm.php');
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
    return $result = $gcm->send_notification($registatoin_ids, $message);



}

//Push notification end

            
        }
        /* for feed */
        
        
        
$result = array("response"=>array('code'=>'201','message'=>"Good News added successfully!!",'data'=>array('last_id'=>$last_id,'image' =>$gnews_image1)));
        print_r(json_encode($result));
    }
     else
      {
        $result = array("response" => array('code' => '200','message' => "Query Failed"));
        print_r(json_encode($result));
    }
} 
else 
{
    $result = array("response" => array('code' => '200','message' => "User not found"));
    print_r(json_encode($result));
}

?> 