<?php
     include ('config/config.php');
  
     if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
     && isset($_REQUEST['f_user_id']) && !empty($_REQUEST['f_user_id']))
     {
        $user_id = $_REQUEST['user_id'];
        $following_u_id = $_REQUEST['f_user_id'];
        
        $hh="Started following you.";
        
        $sql_un="SELECT * FROM `following_by_uid` WHERE `user_id`='$user_id' AND `following`='$following_u_id'";
        $sa=mysqli_query($con,$sql_un);
        $count=mysqli_num_rows($sa);
        
      
        if($count == 0)
           {
         
           
              $query_following_u_Id = "SELECT * FROM registration WHERE  user_id ='$following_u_id'";
              $resnum_following_u_Id = mysqli_query($con,$query_following_u_Id);
              $res_following_u_Id = mysqli_num_rows($resnum_following_u_Id);
              $num_comment = mysqli_fetch_assoc($resnum_following_u_Id);
              $Name = $num_comment['nickname'];
              if($res_following_u_Id  > 0 )
                  {
                     $query = "SELECT * FROM `registration` WHERE user_id = '$user_id' ";
                     $resnum = mysqli_query($con,$query);
                     $res = mysqli_num_rows($resnum);
                     if($res > 0)
                        {
                           $query_check = "SELECT * FROM `following_by_uid` WHERE `user_id`='$user_id' AND `following`='$following_u_id'";
                           $resnum_check = mysqli_query($con,$query_check);
                           $res_check = mysqli_num_rows($resnum_check);
                           if($res_check == FALSE)
                              {                 
                              
                              $query_create_user="INSERT INTO `following_by_uid` ( `user_id`, `following`) 
                              VALUES ( '$user_id ', '$following_u_id')";
                              $created_user = mysqli_query($con,$query_create_user);
                              
                   
                              if (!$created_user)
                                {
                                  $result = array("response"=>array('code'=>'200','message'=>"Query Failed"));
                                  print_r(json_encode($result));
                                }
                                else
                                {
                                $sql="INSERT INTO `followers_by_uid`(`user_id`, `followers`) VALUES ('$following_u_id','$user_id')";
                                $sa1=mysqli_query($con, $sql);
                                  /* for feed add  */
                                  
                                   			          
       			if ($following_u_id == $user_id)
				{
		
						
				}else{
				
				
				/////////////
	  
	  
	  						
//Push notification start 
							
					
 $sql="SELECT * FROM `registration` WHERE `user_id`='$following_u_id' AND `push_res`='1'";
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
 $passphrase = 'ASone';

// Put your alert message here:
//$message = 'My first push notification!';
 $message = $Name." ".$hh ;

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
	

// Close the connection to the server
fclose($fp);
}else{

 $sql="SELECT * FROM `registration` WHERE `user_id`='$following_u_id'";
 $resnum = mysqli_query($con, $sql);
 $res = mysqli_num_rows($resnum);
 $news_feed=mysqli_fetch_assoc($resnum);
 $deviceToken1= $news_feed['device_id'];
 if($deviceToken1){

$deviceToken = $deviceToken1;

// Put your private key's passphrase here:
//$passphrase = 'ASone';
$passphrase = $hh;

// Put your alert message here:

//$message = $nickname." ".$hh ;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

 $ff='Connected to APNS' . PHP_EOL;
//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
/*
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);
	*/
$body['aps'] = array(   
	"content-available" =>'unfollow',
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
	

// Close the connection to the server
fclose($fp);
}
}

//Push notification end
	  
	  //////////////////
				
	$sql2="SELECT * FROM `feeds_m` WHERE `feedowner_id`='$following_u_id' AND `action_owner_id`='$user_id' AND `feed_type`='$hh'";
	$crea2 = mysqli_query($con,$sql2);
	$res12 = mysqli_num_rows($crea2);
	$result_arr = mysqli_fetch_assoc($crea2);	
	$feed_id = $result_arr['id'];	
	
	if($res12 > 0){
	 
	
	 $sql="DELETE FROM `feeds_m` WHERE `id`='$feed_id'";
	$del= mysqli_query($con,$sql);
	if($del){
	
	  $sql_feed="INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`feed_type`) 
	  VALUES ('$following_u_id','$user_id','$hh')";
	  $run=mysqli_query($con, $sql_feed);	
	}

	 $sqll="UPDATE `feeds_m` SET `feedowner_id`='$following_u_id',`action_owner_id`='$user_id',`feed_type`='$hh' WHERE `id`='$feed_id'";
	$cr = mysqli_query($con,$sqll);  
	}else{
	
	  $sql_feed="INSERT INTO `feeds_m`( `feedowner_id`, `action_owner_id`,`feed_type`) 
	  VALUES ('$following_u_id','$user_id','$hh')";
	  $run=mysqli_query($con, $sql_feed);	
	  }
	 
	  
	 }
	 /*     feed */
	 $result = array("response"=>array('code'=>'201','message'=>"You are follow Succesfully."));
          print_r(json_encode($result));
                                }
           
                     
                    }
                    else{
                         $result = array("response"=>array('code'=>'200','message'=>"Allready follow This person"));
                          print_r(json_encode($result));
                         }
                     }else{
                         $result = array("response"=>array('code'=>'200','message'=>"User Id not Exists 1"));
                          print_r(json_encode($result));
                         }
                         
                     }else{
                         $result = array("response"=>array('code'=>'200','message'=>"User Id not Exists 2"));
                         print_r(json_encode($result));
                         
                     }
                  }
                  else{
                  	
                  	
                  	$sql3="DELETE FROM `following_by_uid` WHERE `user_id`='$user_id' AND `following`='$following_u_id'";
                  	mysqli_query($con,$sql3);
                  	
                  	$sql4="DELETE FROM `followers_by_uid` WHERE `user_id`='$following_u_id' AND `followers`='$user_id'";
                  	mysqli_query($con,$sql4);
                  	
                  		  
	  						
//Push notification start 
							
					
 $sql="SELECT * FROM `registration` WHERE `user_id`='$following_u_id' AND `push_res`='1'";
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
 $passphrase = 'ASone';

// Put your alert message here:

// $message = $Name." ".$hh ;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

 $ff='Connected to APNS' . PHP_EOL;
//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(   
	"content-available" =>'unfollow',
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
	

// Close the connection to the server
fclose($fp);
}else{

 $sql="SELECT * FROM `registration` WHERE `user_id`='$following_u_id'";
 $resnum = mysqli_query($con, $sql);
 $res = mysqli_num_rows($resnum);
 $news_feed=mysqli_fetch_assoc($resnum);
 $deviceToken1= $news_feed['device_id'];
 if($deviceToken1){
  // Put your device token here (without spaces):
//$deviceToken = '2b5c659193f47a44abac4451489190203e2d61dc8d855d651c38e90df0848fa8';
//$deviceToken = '5df13eaf838e001afb1f79bd9356fc1dd6e3684f0947906dd44f74047179d447';
$deviceToken = $deviceToken1;

// Put your private key's passphrase here:
//$passphrase = 'ASone';
 $passphrase = 'ASone';

// Put your alert message here:

// $message = $Name." ".$hh ;

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

 $ff='Connected to APNS' . PHP_EOL;
//echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(   
	"content-available" =>'unfollow',
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
	

// Close the connection to the server
fclose($fp);
 
 }
}

//Push notification end
                  	
                         $result = array("response"=>array('code'=>'201','message'=>"You Unfollow Succesfully."));
                         print_r(json_encode($result));
                      }
                     
                     
                     }else{
                         $result = array("response"=>array('code'=>'200','message'=>"No Data Available"));
                         print_r(json_encode($result));
            
        }