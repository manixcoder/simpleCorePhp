<?php
include ('config/config.php');
     if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
     && isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])
     && isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type'])
     )
     	{

		 $user_id = $_REQUEST['user_id'];			
		 $search_text = $_REQUEST['search_text'];
		 $search_type = $_REQUEST['search_type'];
		 
		 $sql="SELECT * FROM `registration` WHERE `user_id`='$user_id'";
		 $result1=mysqli_query($con, $sql);
		 $count=mysqli_num_rows($result1);
		 $res = mysqli_fetch_assoc($result1);
		 if($res == TRUE)
		 {
		 
		
		 $query = "SELECT * FROM `registration` WHERE `nickname` like '$search_text%'";
		 $resnum = mysqli_query($con,$query);
		 $res = mysqli_num_rows($resnum);
		 $r = array();
		 while($result_arr = mysqli_fetch_assoc($resnum))
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
		 
		 if($res > 0 )
		 {
		 	$result = array("response"=>array('code'=>'200','message'=>"Users Found Successfull",'data'=>$r));
		        print_r(json_encode($result));
		 }
		  else
	            {
	               $result = array("response"=>array('code'=>'200','message'=>" User not Registered !!.",'data'=>$r));
	               print_r(json_encode($result));
	            }
	            
		
	
	         }
	         else
	            {
	               $result = array("response"=>array('code'=>'200','message'=>" User not found !!."));
	               print_r(json_encode($result));
	            }
          }
          else
              {
                  $result = array("response"=>array('code'=>'200','message'=>" Data not found !!."));
	          print_r(json_encode($result));
	      }
?>