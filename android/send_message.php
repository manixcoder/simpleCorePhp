<?php
include("../config/config.php");
$regId = "";
//$regId ="";
$message = "Hello This is the test Message";
include_once('gcm.php');
$gcm = new GCM();
$registatoin_ids = array($regId);
$message = array("message" => $message);
$result = $gcm->send_notification($registatoin_ids, $message);
$dd=json_decode($result);
print_r($result );

?>
