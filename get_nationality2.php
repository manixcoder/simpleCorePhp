<?php
include("config/config.php"); 
if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) 
{
	
 $user_id=$_REQUEST['user_id'];
  $r = array();
  
  $result = mysqli_query($con,"SELECT * FROM nationality") or die('Could not query');
		while ($result_arr = mysqli_fetch_assoc($result))
			{
			
			$ff = $result_arr['user_id'];			
			 $id = $result_arr['id'];
			 $sql3 = "SELECT * FROM `nationality` WHERE `user_id`='$user_id' AND `id`='$id'";
				$resnum3 = mysqli_query($con, $sql3);
				$res3 = mysqli_num_rows($resnum3);
				$a = array();
				if ($res3 == 1)
					{
					$result_arr['is_chedked'] = "true";
					
					
			
					

					}
				  else
				  {
				 $result_arr['is_chedked'] = "false";
				 }
			
			
				array_push($r, $result_arr);
				
			}
	$result = array("response"=>array('code'=>'201','message'=>" Data found Successfully!!.",'Data'=>$r));
	print_r(json_encode($result));
	//echo json_encode($emparray);

  
}
else
{


}