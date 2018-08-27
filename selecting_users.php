<?php

include('config/config.php');


if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
{
$user_id = $_REQUEST['user_id'];
   $result = mysqli_query($con,"SELECT * FROM `registration` WHERE `user_id`!='$user_id' ") or die('Could not query');

 $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    $result = array("response"=>array('code'=>'200','message'=>"Users Available"),'data'=>$emparray);
    print_r(json_encode($result));
 }
 else
   {
     $result = array("response"=>array('code'=>'200','message'=>"Data not found"));
     print_r(json_encode($result));
   }
	
	?>