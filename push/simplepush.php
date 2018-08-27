<?php

// Put your device token here (without spaces):
$deviceToken = 'aa445895996020cd5ed692a0a14729bd658b9b57990ddc7779ad3f1e74b476fa';

// Put your private key's passphrase here:
$passphrase = 'pushchat';

// Put your alert message here:
$message = 'My first push notification!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'Muspurposal.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	/*
	$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	*/

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

$hh='Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	$hh= 'Message not delivered' . PHP_EOL;
else
	$hh='Message successfully delivered' . PHP_EOL;
	//print_r($hh);
	
	$result = array("response" => array('code' => '201','message' => "Message sent ",'data'=>$hh));
      print_r(json_encode($result));

// Close the connection to the server
fclose($fp);
