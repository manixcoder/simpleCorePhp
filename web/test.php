<?php



//$regId = "APA91bFto90mumznrW9GYEY2_PEVPfdN_klnhV64kV4hQGO5LcS5c07i6HyYiHE4k0FEmaRheaqzlnULQno7rEw_haiPYTNbwK-hQ9yPNu_P0UCOgWc299XAdrNTbCXqikNoV-hoGOfeGZBOleNIvp6wQv1HJnOiWA";
$regId = "APA91bFD2vGIYiqcjt4vGopF05cjnv6RpexXyk8x4OihoX0RpeeAuicMjemNQpJXzkA92tRTFDBcoW-K0OwZwywiydQcVzYZ5jqgdDiaN6OqVgQKvShfAeA4fOYQcRFPAE0gJIXpp5Fi";
$message = "Hello This is the test Message";

include_once('notification.php');
$registatoin_ids = array($regId);
$message = array("message" => $message);

$result = sendMessage($registatoin_ids, $message);
$dd=json_decode($result);
print_r($dd);


?>