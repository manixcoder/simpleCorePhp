<?php

include('config/config.php');

$user_id  = $_POST['user_id'];
$content1 = isset($_POST['p_content']) ? $_POST['p_content'] : '';
//$content  = preg_replace("/[^a-zA-Z0-9\s\p{P}]/", "", $content1);
$content = mysqli_real_escape_string($con,$content1);
$p_image1 = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';


$date_tine = $_POST['datetime'];
//echo $date_tine = preg_replace("/[^a-zA-Z0-9\s\p{P}]/", "", $date_tine);


$type   = 'Posted Prayer';

$qry    = "SELECT * FROM registration WHERE user_id = '$user_id'";
$resnum = mysqli_query($con, $qry);
$res    = mysqli_num_rows($resnum);
 $res1     = mysqli_fetch_assoc($resnum);
 $nickname = $res1['nickname'];

if ($res == 1) {
    if ($p_image1 != '') {
        $file_path = "uploads/";
        $file_path = $file_path . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
        if ($p_image1 != '') {
            
           // $p_image = BASE_URL . "/asone_app/uploads/" . $p_image1;
            $p_image = "asone_app/uploads/" . $p_image1;
        } else {
            $p_image = '';
        }
    }
   
    
    
    $sql     = "INSERT INTO `add_prayer` (`user_id`, `prayer_content`, `payer_image`,`datetime`) VALUES ( '$user_id', '$content', '$p_image','$date_tine')";
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
           VALUES ('$user_get_feed','$user_id','$last_id','$content','$p_image','$type')";
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
 
 // Put your device token here (without spaces):
//$deviceToken = '2b5c659193f47a44abac4451489190203e2d61dc8d855d651c38e90df0848fa8';
//$deviceToken = '5df13eaf838e001afb1f79bd9356fc1dd6e3684f0947906dd44f74047179d447';
$deviceToken = $deviceToken1;

// Put your private key's passphrase here:
//$passphrase = 'ASone';


// Put your alert message here:
$message = 'My first push notification!';
$message = $nickname. " " .$type ;

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
	 

fclose($fp);
}

//Push notification end

            
            
        }
        /* for feed */
        $result = array(
            "response" => array(
                'code' => '201',
                'message' => "Prayer added successfully!!",
               
                 'data'=>array('last_id'=>$last_id, 'image' =>$p_image) 
            )
        );

        print_r(json_encode($result));
    } else {
        $result = array(
            "response" => array(
                'code' => '200',
                'message' => "Query Failed"
            )
        );
        print_r(json_encode($result));
        
    }
} else {
    $result = array(
        "response" => array(
            'code' => '200',
            'message' => "User not found"
        )
    );
    print_r(json_encode($result));
    
}