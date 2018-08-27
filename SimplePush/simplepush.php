<?php

// Put your device token here (without spaces):

$deviceToken = 'c5614e18d7f7934e555f98233c5f8df3d3855c5002a8654be89c4751e13db148';

// Put your private key's passphrase here:

$passphrase = '123456';

// Put your alert message here:

$message = 'My first Push Notification...!';

// //////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

//Production:
    $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
    //Development:
    //$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);



if (!$fp)
	{
	exit("Failed to connect: $err $errstr" . PHP_EOL);
	}
  else
	{
	$gh = 'Connected to APNS' . PHP_EOL;
	}

// Create the payload body

$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'badge' => '+1'
);

// Encode the payload as JSON

$payload = json_encode($body);
$ddd = json_decode($payload);

for ($i = 0; $i < 2; $i++)
	{

	// Build the binary notification

	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

	// Send it to the server

	$result = fwrite($fp, $msg, strlen($msg));

	// echo "msg may be delivered";

	}

if (!$result) $tt = 'Message not delivered' . PHP_EOL;
  else $tt = 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server

fclose($fp);
$result1 = array(
	"response" => array(
		'code' => '201',
		'message' => " Push Notification send  !!.",
		'data' => $ddd
	)
);
print_r(json_encode($ddd));

