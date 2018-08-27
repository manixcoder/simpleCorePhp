<?php
include('config/config.php');

if(
    isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&& isset($_REQUEST['f_id']) && !empty($_REQUEST['f_id'])
 && isset($_REQUEST['msg'])&& !empty($_REQUEST['msg'])
    )
 
{ 
    //$dt = new DateTime();
   // $date=$dt->format('Y-m-d H:i:s');
        
   $user_id = $_REQUEST['user_id'];

   $f_id= $_REQUEST['f_id'];
    
  $msg= $_REQUEST['msg'];
 
    $qry = "SELECT * FROM registration WHERE user_id = '$f_id'";

    $resnum = mysqli_query($con,$qry);
    $res = mysqli_num_rows($resnum);

    while($news_feed=mysqli_fetch_array($resnum))
       {
        $f_name= $news_feed['username'];
        $f_vocation= $news_feed['vocation'];
        $f_profile_image = $news_feed['profile_image'];
        
       }     
    if($res == 1)
    	{
            $sql="INSERT INTO `a1pro_asone_app`.`chat` (`user_id`, `frnd_id`, `f_name`, `f_profile_image`, `f_vocation`) VALUES ('$user_id', '$f_id', '$f_name', '$f_profile_image', '$f_vocation')";    
            
            $results=  mysqli_query($con, $sql);
            
            if($results)
                {
// $result = array("response"=>array('code'=>'201','message'=>"Message sent Successfully!! "));
  //    		print_r(json_encode($result));

$m1=mysqli_query($con,"INSERT INTO `a1pro_asone_app`.`chat_conversation` (`user_id`, `f_id`, `msg`) VALUES ('$user_id', '$f_id', '$msg')");

if($m1)
{
$result = array("response"=>array('code'=>'201','message'=>"Message sent Successfully!! "));
      		print_r(json_encode($result));
}

else
{
$result = array("response"=>array('code'=>'201','message'=>"Message sent Successfully!! "));
      		print_r(json_encode($result));
} 
                }else
                    {
                    $result = array("response"=>array('code'=>'200','message'=>"Message sending Error!!!"));
      		    print_r(json_encode($result));
                    
                }
    	}
    	else
                    {
                    $result = array("response"=>array('code'=>'200','message'=>"User not found"));
      		    print_r(json_encode($result));
                    
                }
    
    
 }
 else
 	{
$result = array("response"=>array('code'=>'200','message'=>"Data not found"));
 	print_r(json_encode($result));
 	}
?>