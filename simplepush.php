<?php
include("config/config.php");

  
        $send_to= $_POST['send_to'];
     	 $send_from = $_POST['send_from'];
     	 $message = $_POST['message'];
     	  $type = $_POST['type'];
     	// $packet_id = $_POST['packet_id'];



 $sql="SELECT * FROM `registration` WHERE `username`='$send_to' AND `device_type`='$type'";
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
$passphrase = 'pushchat';

// Put your alert message here:
//$message = 'My first push notification!';

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
	$result1 = array("response"=>array('code'=>'201','message'=>" Push Notification send  !!.",'data'=>$ddd));
        print_r(json_encode($result1));

// Close the connection to the server
fclose($fp);
}

