<?php
include ('config/config.php');
if(isset($_REQUEST['username']) && !empty($_REQUEST['username']))
	{
	
	   $username = $_REQUEST['username'];
	   $status = '0';
	   
	   //$sql="SELECT * FROM `registration` WHERE `username`='$username'";
	   $sql= "SELECT * FROM `registration` WHERE `username`='$username' AND `status`='1'";
	   $result1=mysqli_query($con, $sql);
	   $count=mysqli_num_rows($result1);
	   $res = mysqli_fetch_assoc($result1);
	          if($res != 0)
	              {
	                 $result = array("response"=>array('code'=>'201','message'=>"Logout Successfully "));
	                 print_r(json_encode($result));
	                 
	                 
	                 $update="UPDATE `registration` SET `status`='$status' WHERE `username`='$username'";
	                 $query= mysqli_query($con, $update);
	              }
	              else
	                 {
	                    $result = array("response"=>array('code'=>'200','message'=>" Login first."));
	                    print_r(json_encode($result));
	                 }
	 }
	 else
	     {
	        $result = array("response"=>array('code'=>'200','message'=>"Data not found ."));
	        print_r(json_encode($result));
	     }
       
 ?>

