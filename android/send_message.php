<?php
include("../config/config.php");
$regId = "cbFW-BZwE4I:APA91bGpQMAPq4i4W5eSW0vgZghPpCWWifpU29cEp71G8COBioKDzDwvwlNSAUtu1d1mnl0livwnvxbFCA2JGZfFcUbL53yBcRXojAWPoPlWhdGO8m0GZ1gu6e7K8T3LWthzwS2yFkHU";
//$regId ="flI4EbgWrkU:APA91bHMTaeGeeZlfY-RUcKxTpP1yqixjZYAk6reKTVdl43A5hgpw_OxU0NwjxkkPUdNEA4gC6KzHyfwkCLEOOxT92mbla8mPGLQ1-0glkRthmkwm_kud-Fgep_vYrf4R6CqAbrMDIWD";
$message = "Hello This is the test Message";
include_once('gcm.php');
$gcm = new GCM();
$registatoin_ids = array($regId);
$message = array("message" => $message);
$result = $gcm->send_notification($registatoin_ids, $message);
$dd=json_decode($result);
print_r($result );

?>