<?php

include("config/config.php"); 

if(
  isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&&isset($_REQUEST['old_password']) && !empty($_REQUEST['old_password'])
&&isset($_REQUEST['new_password']) && !empty($_REQUEST['new_password'])
) 
{
	
   $user_id=$_REQUEST['user_id'];

    $old_password=$_REQUEST['old_password'];
	
    $new_password=$_REQUEST['new_password'];

    
	$sql="select username from registration where `user_id`='$user_id'";
	
	
    $query = mysqli_query($con,$sql) or die(mysqli_error($con)); 
    if(mysqli_num_rows($query)==1)
    {
	   $data=mysqli_fetch_assoc($query);

	 $username=$data['username'];
      
	
		$query22 = "select *  from registration where `username`='$username' and `password`='$old_password'";

$resnum22 = mysqli_query($con,$query22);


   $res22 = mysqli_num_rows($resnum22);

if($res22!=0)
{

		$upd = "Update registration SET `password`='$new_password' where `user_id`='$user_id'";

 

  
$result_arr=mysqli_query($con,$upd);

		        if($result_arr)
		            {
		             
 $result = array("response"=>array('code'=>'201','message'=>"Password changed successfully!!.."));
		                     print_r(json_encode($result));
		            }
		       else
			   {
			    $result = array("response"=>array('code'=>'201','message'=>"Error in Updation!!.."));
		                     print_r(json_encode($result));
			   }
		
		
            
        }
        
      

 else
		            {
		                      $result = array("response"=>array('code'=>'200','message'=>"Old Password is not correct"));
		                      print_r(json_encode($result));
		            }
		





	  
    }
	
	
	
	else
           {
            $result = array("response"=>array('code'=>'200','message'=>"No user exist with this User Id"));
            print_r(json_encode($result));
            
  
        }
	
	
	
	}
    else
        {
            $result = array("response"=>array('code'=>'200','message'=>"No Data Found"));
            print_r(json_encode($result));
        }
?>
    