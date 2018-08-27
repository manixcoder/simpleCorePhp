<?php
include ('config/config.php');

if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']) 
&& isset($_REQUEST['opp_id']) && !empty($_REQUEST['opp_id']))
{
   $user_id = $_REQUEST['user_id'];
   $f_id = $_REQUEST['opp_id'];
 	
 	
  	$sql="SELECT * FROM `registration` WHERE `user_id`='$user_id'";
 	$result=mysqli_query($con, $sql);
 	$count=mysqli_num_rows($result);
 	$res = mysqli_fetch_assoc($result);
   	if($res != 0)
   	{
 		$sql1="SELECT * FROM `registration` WHERE `user_id`='$f_id'";
 		$result1=mysqli_query($con, $sql1);
 		$count1=mysqli_num_rows($result1);
 		$res1 = mysqli_fetch_assoc($result1);
 		if($res1 == TRUE)
 		{
 		    if($user_id > $f_id)
 		       {
 		          $tmp=$f_id;
 		          $f_id=$user_id;
 		          $user_id=$tmp;
 		       }
 		     echo  $sql2="
 		       SELECT r.nickname,r.profile_image,r.l_code,ch.* FROM chats ch join registration r on ch.user_id='$user_id' AND ch.opp_id='$f_id' OR ch.user_id='$f_id' AND ch.opp_id='$user_id' where ch.opp_id=r.user_id or ch.opp_id=r.user_id
 		       ";
die;
 //	$sql2="SELECT * FROM `chats` WHERE user_id = '$user_id' AND `f_id`='$f_id' OR `f_id`='$user_id' AND`user_id`= '$f_id' order by `id` ";
 		       $result2 = mysqli_query($con, $sql2);
 		       //$res2 = mysqli_fetch_assoc($result2);
 		       $r = array();
 		       while($result_arr = mysqli_fetch_assoc($result2))
			{
			  if($result_arr)
			      {
			          array_push($r,$result_arr);
			      }
			      else
			         {
			            $result = array("response"=>array('code'=>'200','message'=>"Activities Likes not found"));
			            print_r(json_encode($result));
			         }
			}
			  // echo "<pre>";
			  // print_r($r);
			  
			
			
		    /* $sql1="SELECT * FROM `chats` WHERE `f_id`='$f_id' AND `user_id`='$user_id' ORDER BY `id` DESC";
 		     $result1 = mysqli_query($con, $sql1);
 		     $res2 = mysqli_fetch_assoc($result1);
 		     
			while($result_arr1 = mysqli_fetch_assoc($result1))
			{
			  if($result_arr1)
			      {
			          array_push($r,$result_arr1);
			      }
			      else
			         {
			            $result = array("response"=>array('code'=>'200','message'=>"Activities Likes not found"));
			            print_r(json_encode($result));
			         }
			}*/
//			if($res2!=0)
if($result2)
			{
			//$data2[] = array('data' => $res2, 'communication' => $r);
				$result = array("response"=>array('code'=>'201','message'=>"Chat found successfully",'Data'=> $r));
			        print_r(json_encode($result));
			}
 		        
 		}
 		else
 		{
 			$result = array("response"=>array('code'=>'200','message'=>"Freind Id2 not found"));
  	        	print_r(json_encode($result));
 		
 		}
 	}
 	else
 	{
 		$result = array("response"=>array('code'=>'200','message'=>"User Id not found"));
  	        print_r(json_encode($result));
 	}
 	}
 	else
 	{
 		$result = array("response"=>array('code'=>'200','message'=>"Data not found"));
  	        print_r(json_encode($result));
 	}