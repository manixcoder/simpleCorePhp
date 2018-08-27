<?php
include ('config/config.php');

if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&& isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])
&& isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type'])
&& isset($_REQUEST['vocation'])
&& isset($_REQUEST['nation_id']))
	    {    

	     	$rnew = array();
	     	
	        $user_id = $_REQUEST['user_id'];			
	        $search_text = $_REQUEST['search_text'];
	        $search_type = $_REQUEST['search_type'];
	        $vocat = $_REQUEST['vocation'];
	        
                $voc = explode(',',$vocat);
                //print_r($voc); die();


	        /*
	        search_type=  1 -> Globe
	        search_type=  2 -> My Connections
	        search_type=  3 -> Specific Connections
	        */

	        
	        $sql="SELECT * FROM `registration` WHERE `user_id`='$user_id'";
	        $result1=mysqli_query($con, $sql);
	        $count=mysqli_num_rows($result1);
	        $res = mysqli_fetch_assoc($result1);
	            if($res == TRUE)
	               {
	                 if($search_type == 1)
	                   {
	                   		foreach($voc as $data){
	                    		$query = "SELECT * FROM `registration` WHERE `nickname` like '$search_text%' AND `vocation` = '$data'";
	                      		$resnum = mysqli_query($con,$query);
	                      		//$res = mysqli_num_rows($resnum);
	                     	    $r = array();
	                     	    while($result_arr = mysqli_fetch_assoc($resnum))
	                      			{				                      	
				                     if($result_arr)
				                         {

			                                   array_push($rnew,$result_arr);
				                           
				                         } 				                     
				                    }                         	
	                 	 	}	
	                  
	                   }
	                
				        if($res > 0 )
				  		  	{
					          	if(!empty($rnew))
						         	{
						          		$result = array("response"=>array('code'=>'201','message'=>"Users Found Successfull",'data'=>$rnew));
						              	print_r(json_encode($result));
						          
						          	}else{
							           $result = array("response"=>array('code'=>'200','message'=>" Users not Found !!.",'data'=>$rnew));
							                print_r(json_encode($result));
						        	}
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