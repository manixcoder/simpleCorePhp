<?php
include ('config/config.php');
	
		$username = $_POST['username'];
		$password = $_POST['password'];		
		$device_id = $_POST['device_id'];
		$device_type = $_POST['device_type'];
		
		$status = '1';
		$sql="SELECT * FROM `registration` WHERE `username`='$username' AND `password`='$password'";
		$result1=mysqli_query($con, $sql);
		$count=mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		if($res != 0)
		{
		
		$update="UPDATE `registration` SET `status`='$status',`device_id`='$device_id',`device_type`='$device_type' WHERE `username`='$username'";
		 
		   $query= mysqli_query($con, $update);
		   
		   $sql1="SELECT * FROM `registration` WHERE `username`='$username' ";
		   $result=mysqli_query($con, $sql1);
		   $res1 = mysqli_fetch_assoc($result);
		   
		   $result = array("response"=>array('code'=>'201','message'=>"Your Login Is Successfully...",'Record'=>$res1));
		   print_r(json_encode($result));
		   

		   
		}
		else
		   {
		      $result = array("response"=>array('code'=>'200','message'=>"User or Password not found"));
		      print_r(json_encode($result));
		   }
		
    
 ?>

