<?php
include("config/config.php"); 
if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&&isset($_REQUEST['sel_id']) 
&&isset($_REQUEST['state']) ) 
{
	
  $user_id=$_REQUEST['user_id'];
  $sel_id =$_REQUEST['sel_id'];
  $state =$_REQUEST['state'];
  $sel_id1 = explode(",", $sel_id);
  
 
 foreach($sel_id1 as $id)
  {
  
  if($state== "1")
  {
    $sql ="UPDATE `nationality` SET `user_id`='$user_id',`status`='1' WHERE `id`='$id'";
    $ex= mysqli_query($con,$sql);
   } 
       else
       {
         $sql ="UPDATE `nationality` SET `user_id`='0',`status`='0'";
         $ex= mysqli_query($con,$sql);
       
       
       }   
  
  }
  
  if($ex)
     {
        $result = array("response"=>array('code'=>'201','message'=>"Updated Successfully!!."));
        print_r(json_encode($result));
  
                }
                else
                   {
                      $result = array("response"=>array('code'=>'200','message'=>"Data selscted !."));
                      print_r(json_encode($result));
  
                   }
                   
  }
  else{
   $result = array("response"=>array('code'=>'200','message'=>" Data not found !."));
    print_r(json_encode($result));
  
  }

?>