<?php
include('config/config.php');
if(isset($_REQUEST['user_id'])){

       $user_id = $_REQUEST['user_id']; 
       $qry    = "SELECT * FROM registration WHERE user_id = '$user_id'";
    $resnum = mysqli_query($con, $qry);
    $res1    = mysqli_num_rows($resnum);
    if ($res1 != 0) {

    $query = "SELECT * FROM `vacation` where user_id = '$user_id'";

$resnum2 = mysqli_query($con,$query);


   $res2 = mysqli_num_rows($resnum2);

if($res2!=0)
{
  $r = array();
		while($result_arr2 = mysqli_fetch_assoc($resnum2))
		   {
		        
		               array_push($r,$result_arr2);

		            
					} 
					
				/*	 $result = array("response"=>array('code'=>'201','message'=>"Data found successfully ..",'data'=>$r));
		                     print_r(json_encode($result));
					*/
					/*----------------------Default------------------------*/
					
					
					 $query3 = "SELECT * FROM `vacation` where user_id = '0'";

$resnum23 = mysqli_query($con,$query3);


   $res23 = mysqli_num_rows($resnum23);

if($res23!=0)
{
  $r3 = array();
		while($result_arr2 = mysqli_fetch_assoc($resnum23))
		   {
		        
		               array_push($r3,$result_arr2);

		            
					} 
					
					 $result = array("response"=>array('code'=>'201','message'=>"Data found successfully ..",'data1'=>$r,'data2'=>$r3));
		                     print_r(json_encode($result));
					
					
					}
					
					
					
					/*----------------------Default------------------------*/
					}else{
					
					$query34 = "SELECT * FROM `vacation` where user_id = '0'";
					$resnum234 = mysqli_query($con,$query34);
					$res234 = mysqli_num_rows($resnum234);
					if($res234!=0)
					   {
					   $r4 = array();
					   while($result_arr24 = mysqli_fetch_assoc($resnum234))
					     {
					        array_push($r4,$result_arr24);
					     }
					     
					     $result = array("response"=>array('code'=>'201','message'=>"Data found successfully ..",'data2'=>$r4));
					     print_r(json_encode($result));
					   }
		                      }
		                      
		   }else
		       {
		       $result = array("response" => array('code' => '200','message' => "User not Exists"));
		       print_r(json_encode($result));
		       }
	}else{

 $query = "SELECT * FROM `vacation` where user_id ='0'";

$resnum = mysqli_query($con,$query);


   $res = mysqli_num_rows($resnum);

if($res!=0)
{
  $r = array();
		while($result_arr = mysqli_fetch_assoc($resnum))
	{	    array_push($r,$result_arr);
}
		        if($r!="")
		            {
		              
 $result = array("response"=>array('code'=>'201','message'=>"Data found successfully ..",'data'=>$r));
		                     print_r(json_encode($result));
		            }
		        else
		            {
		                      $result = array("response"=>array('code'=>'200','message'=>"Vocation not found"));
		                      print_r(json_encode($result));
		            }

}

}
?>