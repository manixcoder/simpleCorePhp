<?PHP
include ("../config/config.php");
/*
$db_user = "xxx"; // Gebruiker voor MySQL
$db_pass = "xxx"; // Wachtwoord voor MySQL
$db_host = "localhost"; // Host voor MySQL; standaard localhost
$db_db = "xxx"; // Database

// Als je al ergens anders een database connectie hebt gemaakt,
// maak dan van de volgende twee regels commentaar (# of // ervoor zetten)
mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_db);


 $sql="SELECT * FROM `registration`";
 $resnum = mysqli_query($con, $sql);
 $res = mysqli_num_rows($resnum);
 //$news_feed=mysqli_fetch_assoc($resnum);
 $dd= $news_feed['device_type'];

// $deviceToken1= $news_feed['device_id'];

 
 // Put your device token here (without spaces):
//$deviceToken = '2b5c659193f47a44abac4451489190203e2d61dc8d855d651c38e90df0848fa8';
//$deviceToken = '5df13eaf838e001afb1f79bd9356fc1dd6e3684f0947906dd44f74047179d447';
$deviceToken = $deviceToken1;
*/
//$query = mysql_query("SELECT * FROM iospush");

                                    
                                    
 

if($_POST['message']){

$devArray = array();
 $sql="SELECT * FROM `registration`";
 $resnum = mysqli_query($con, $sql);
 $res = mysqli_num_rows($resnum);
 /*
  while ($row = mysqli_fetch_assoc($resnum)) {
        $deviceToken = $row["device_id"];
     }
*/
	while($result_arr = mysqli_fetch_assoc($resnum))
		{
		   if($result_arr)
		       {
		          array_push($devArray,$result_arr);
		       }
		      
		}	
   $deviceToken = $result_arr['device_id'];

//  $deviceToken = 'xxx';

    $message = stripslashes($_POST['message']);
/*
    $payload = '{
                    "aps" : 

                        { "alert" : "'.$message.'",
"badge" : 1
                        } 
                }';
*/

 $body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

    $ssl='ck.pem';

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', $ssl);
    stream_context_set_option($ctx, 'ssl', 'passphrase', 'xxx');
    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
    if(!$fp){
        print "Failed to connect $err $errstrn";
        return;
    } else {
        print "Notifications sent!";
    }

    
    $devArray[] = $deviceToken;
    
    echo "<pre>";
    print_r($devArray);

    foreach($devArray as $deviceToken){
        $msg = chr(0) . pack("n",32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack        ("n",strlen($payload)) . $payload;
        print "sending message :" . $payload . "n";

        fwrite($fp, $msg);
    }
    fclose($fp);
}



?>
<form action="multiple.php" method="post">
    <input type="text" name="message" maxlength="100">
    <input type="submit" value="Send Notification">
</form>