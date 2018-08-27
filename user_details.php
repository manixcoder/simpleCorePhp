<?php
include('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&& isset($_REQUEST['opp_id']) ) {

    $user_id = $_REQUEST['user_id'];
    $opp_id = $_REQUEST['opp_id'];
    

     if(!empty($opp_id) ){
       $query  = "SELECT * FROM registration WHERE user_id='$opp_id'";
       }
       else
       {
       $query  = "SELECT * FROM registration WHERE user_id='$user_id'";
       }
   
    $resnum = mysqli_query($con, $query);
    $res    = mysqli_num_rows($resnum);
    
    if ($res == TRUE) {
    
    if(!empty($opp_id)){
    
            $sql    = "SELECT * FROM registration WHERE user_id='$opp_id'";
       }
       else
       {
        $sql    = "SELECT * FROM registration WHERE user_id='$user_id'";
       }
            
       
        $result = mysqli_query($con,$sql);
         $count   = mysqli_num_rows($result);
         
        if ($count > 0) 
        {
       
      

            while ($row = $result->fetch_assoc()) 
            {
                $profile_image = $row["profile_image"];
                $flage         = $row["flag"];
                $nickname      = $row["nickname"];
                $vocation      = $row["vocation"];
                $nationality = $row['nationality'];
                $language =$row['language'];
                $l_code =$row['l_code'];
                $gender = $row['gender'];
                $nationality_id = $row['nationality_id'];
                $date_birthday = $row['date_birthday'];
            }
        } 
        else 
        {
            $result = array("response" => array('code' => '200','message' => "User not found!!!"));
            print_r(json_encode($result));
            
            
        }   $opp_id = $_REQUEST['opp_id'];
        if(!empty($opp_id) )
        {
               $query  = $opp_id;
        }
        else
        {
        	     $query  = $user_id;
        }
   
    $count1 ="SELECT COUNT(followers) as followers FROM `followers_by_uid` WHERE `user_id`='$query'";      
        $count_nun1 = mysqli_query($con, $count1);
        
        while ($num_comment = mysqli_fetch_assoc($count_nun1))
         {
         	$countss1 = $num_comment['followers'];
         }
       
    /*  if(!empty($opp_id)){
       $count2     = "SELECT COUNT(following) as following FROM following_by_uid WHERE user_id ='$opp_id'";
       }else{
     $count2     = "SELECT COUNT(following) as following FROM following_by_uid WHERE user_id ='$user_id'";
       }*/
   $count2     = "SELECT COUNT(following) as following FROM following_by_uid WHERE user_id ='$query'";
        $count_nun2 = mysqli_query($con, $count2);
        $res3    = mysqli_num_rows($count_nun2);
        while ($num_comment2 = mysqli_fetch_assoc($count_nun2))
         {
            $countss3 = $num_comment2['following'];
        }
         if ($result > 0) 
         {
            
          if (isset($_REQUEST['opp_id']) )
           {
            
                $opp_id = $_REQUEST['opp_id'];
                
                $op1 = "SELECT COUNT(following) as following FROM following_by_uid WHERE following ='$opp_id' and user_id='$user_id'"; 
                $op2 = mysqli_query($con, $op1);
                $res2    = mysqli_num_rows($op2);
                
                while ($opp2 = mysqli_fetch_assoc($op2))
                 {
                  $opp3 = $opp2['following'];
                  
                }
                
                 if(!empty($opp_id) )
                 {
                 $query  = $opp_id;
                }
                else
                {
                $query  = $user_id;             
                }
                if ($opp3 >= 1) 
                {
           
               
               
                
                $data2[] = array('User Id' => $query,'nickname' => $nickname,'profile_image' => $profile_image,'Flag' => $flage,
                    'follower' => $countss1,'following' => $countss3,'vocation' => $vocation,'is_follow' =>1,'nationality'=>$nationality,'language'=>$language,'gender'=>$gender,'nationality_id'=>$nationality_id,'birthday'=>$date_birthday);
                                        
                    $result = array("response" => array('code' => '201','message'=>"User Data found successfully...",'data'=>$data2));
                    print_r(json_encode($result));
                    }
                    else
                    {
                    
                    if(!empty($opp_id) )
                    {
                    $query1  = $opp_id;
                    }
                    else
                    {
                    $query1  = $user_id;
                    } 
                
               $data2[] = array('User Id' => $query1,'nickname' => $nickname,'profile_image' => $profile_image,'Flag' => $flage,
               'l_code'=>$l_code,'follower' => $countss1,'following' => $countss3,'vocation' => $vocation,'is_follow' => 0 ,'nationality'=>$nationality,'language'=>$language,'gender'=>$gender,'nationality_id'=>$nationality_id,'birthday'=>$date_birthday);
                
                
                
                
                $result = array("response" => array('code' => '201','message' => "User Data found successfully...",'data'=>$data2));
                print_r(json_encode($result));
                }
            }
            else
            {
                
                 
                  $data2[] = array('User Id' => $query1,'nickname' => $nickname,'profile_image' => $profile_image,'Flag' => $flage,
               'l_code'=>$l_code,'follower' => $countss1,'following' => $opp3,'vocation' => $vocation,'is_follow' => 0 ,'nationality'=>$nationality,'language'=>$language,'gender'=>$gender,'nationality_id'=>$nationality_id);
                 
                 $result = array("response" => array('code' => '201','message' => "User Data found successfully...",'data' => $data2));
                 print_r(json_encode($result));
                 }
          
              } else {
              $result = array("response" => array('code' => '200','message' => "User Id doesn't exist!!!" ) );
                 print_r(json_encode($result));
    }
    
    
} else {
         $result = array("response" => array('code' => '200','message' => "Data not Found!!!"));
         print_r(json_encode($result));
      }
      
     
}else{
   $result = array("response" => array('code' => '200','message' => "Data not Found22!!!"));
         print_r(json_encode($result));
}
?>