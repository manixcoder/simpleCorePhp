<?php
include ('config/config.php');
	if(isset($_REQUEST['username']) && !empty($_REQUEST['username']) 
	&& isset($_REQUEST['password']) //&& !empty($_REQUEST['password'])
	&& isset($_REQUEST['is_from_fb'])
	 )
	{
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$is_from_fb = $_REQUEST['is_from_fb'];
		
		$status = '1';
		
		if($is_from_fb=='1'){
		//echo "Hello";
		$sql="SELECT * FROM `registration` WHERE `username`='$username'";
		$result1=mysqli_query($con, $sql);
		$count=mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		if($res != 0)
		{
		   $result = array("response"=>array('code'=>'201','message'=>"Your Login Is Successfully...",'Record'=>$res));
		   print_r(json_encode($result));
		   
		   $update="UPDATE `registration` SET `status`='$status' WHERE `username`='$username'";
		   $query= mysqli_query($con, $update);
		   
		}
		else
		   {
		      $result = array("response"=>array('code'=>'200','message'=>" The email and password you entered don't match."));
		      print_r(json_encode($result));
		   }
		
		
		}
		else{  
		
		//echo "Hi";
		
		$sql="SELECT * FROM `registration` WHERE `username`='$username' AND `password`='$password'";
		$result1=mysqli_query($con, $sql);
		$count=mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		if($res != 0)
		{
		   $result = array("response"=>array('code'=>'201','message'=>"Your Login Is Successfully...",'Record'=>$res));
		   print_r(json_encode($result));
		   
		   $update="UPDATE `registration` SET `status`='$status' WHERE `username`='$username'";
		   $query= mysqli_query($con, $update);
		   
		}
		else
		   {
		      $result = array("response"=>array('code'=>'200','message'=>" The email and password you entered don't match."));
		      print_r(json_encode($result));
		   }
		   }
       }
       else
          {
          	$result = array("response"=>array('code'=>'200','message'=>" Data not found !!."));
          	print_r(json_encode($result));
          }
 ?>

