<?php
include ('config/config.php');

	$user_id = $_POST['user_id'];			
	$search_text = $_POST['search_text'];
	$search_type = $_POST['search_type'];
        $voc_id = $_POST['voc_id'];
	$nation_id = $_POST['nation_id'];
	/* 	
	search_type=  1 -> Globe
	search_type=  2 -> My Connections
	search_type=  3 -> Specific Connections
	*/
	
	$sql_v="SELECT * FROM `vacation` WHERE `v_id`='$voc_id'";
	$resnum = mysqli_query($con,$sql_v);
	$res1 = mysqli_num_rows($resnum);
	$news_feed=mysqli_fetch_assoc($resnum);
	
	$vacation= $news_feed['vacation'];
	

		$sql="SELECT * FROM `registration` WHERE `user_id`='$user_id'";
		$result1=mysqli_query($con, $sql);
		$count=mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		if($res == TRUE)
		{
		   if($search_type == 1)
		   {
		      $member_nation_id = explode(',',$nation_id);
		      
		   // print_r($member_nation_id);
		  
		      
$r = array();
 foreach($member_nation_id as $n_id )
	{	
	$nd_id = $n_id['nationality_id'];   
	  if($voc_id =="all")
	  {
$query = "SELECT * FROM `registration` WHERE  `nationality_id`='$nd_id'  AND `nickname` like '$search_text%' ORDER BY `user_id` DESC  ";
$resnum = mysqli_query($con,$query);
		      }
		      else
		         {
$query = "SELECT * FROM `registration` WHERE  `nationality_id`='$nd_id'   AND `nickname` like '$search_text%' ORDER BY `user_id` DESC ";
$resnum = mysqli_query($con,$query);
}
	while($result_arr = mysqli_fetch_assoc($resnum))
		{
		   if($result_arr)
			{
				array_push($r,$result_arr);
			}
		}
	
		}
		
		
	                 }
	                 if($search_type == 2)
	                    {
	                    
	                      $sql2="SELECT `following` FROM `following_by_uid` WHERE `user_id` = '$user_id'";
	                       $dd=mysqli_query($con, $sql2);
	                       $r2 = array();
	                       while($result_arr1 = mysqli_fetch_assoc($dd))
	                          {
	                         
	                            if($result_arr1)
	                              {
	                                 array_push($r2,$result_arr1);
	                              }
	                          } 
	                          //$sql2="SELECT `following` FROM `following_by_uid` WHERE `user_id` = '$user_id'";           
	                          $sql2= "SELECT `followers` FROM `followers_by_uid` WHERE `user_id`='$user_id'";
	                          $dd2=mysqli_query($con, $sql2);
	                          while($result_arr2 = mysqli_fetch_assoc($dd2))
	                          {
	                           
	                           if($result_arr2)
	                              {
	                                 array_push($r2,$result_arr2);
	                              }
	                          }
	                     
		    
	                          $r = array();
	                        //  echo "<pre>";
	                        //  print_r($r2);
	                       
	                          foreach($r2 as $key)
	                          {
	                          		                          
	                         	 $id1 = $key['following'];
	                         	 $id =  $key['followers'];
	                         	 
		                         $member_nation_id = explode(',',$nation_id);
	                     
		    	 // $tt= count($member_nation_id);
	                         	 foreach($member_nation_id as $n_id)
	                            		{
		
							$nd_id = $n_id['nationality_id'];
							
if($voc_id =="all"){

							
$query = "SELECT distinct * FROM `registration` WHERE  `nationality_id`='$nd_id' AND  user_id ='$id1' OR user_id ='$id' AND `nickname`  like '$search_text%'";

}
else
{

 $query = "SELECT distinct * FROM `registration` WHERE  `nationality_id`='$nd_id' AND  vocation = '$vacation' AND user_id ='$id1' OR user_id ='$id' AND `nickname`  like '$search_text%'";


}
//echo $query = "SELECT * FROM `registration` WHERE  `nationality_id`='$nd_id' AND    user_id ='$id1' AND `nickname`  like '$search_text%'";
							
							
	} 
				        }
	 $resnum = mysqli_query($con,$query);
	
	while($result_arr = mysqli_fetch_assoc($resnum))
		{
			if($result_arr)
				 {
					array_push($r,$result_arr);
							      }
							  }
				        
//echo "<pre>";
//print_r($resnum);
				   
		          }
		          if($res > 0 )
		             {
		               if(!empty($r))
		                  {
		                    $result = array("response"=>array('code'=>'201','message'=>"Users Found Successfull",'data'=>$r));
		                    print_r(json_encode($result));
		                  }
		                  else
		                     {
		                        $result = array("response"=>array('code'=>'200','message'=>" Users not Found !!.",'data'=>$r));
		                        print_r(json_encode($result));
		                     }
		             }
      }
      else
         {
            $result = array("response"=>array('code'=>'200','message'=>" Data not found !!."));
            print_r(json_encode($result));
         }
/*  }
else
{
$result = array("response"=>array('code'=>'200','message'=>" Data not found !!."));
print_r(json_encode($result));
}*/
?>