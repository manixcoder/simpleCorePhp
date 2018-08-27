<?php
include ('config/config.php');


     if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
     && isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])
     && isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type'])
     && empty($_REQUEST['nation_id']) && empty($_REQUEST['vocation']))
     {
        $user_id = $_REQUEST['user_id'];            
        $search_text = $_REQUEST['search_text'];
        $search_type = $_REQUEST['search_type'];
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
                      $query = "SELECT * FROM `registration` WHERE `nickname` like '$search_text%'";
                      $resnum = mysqli_query($con,$query);
                      //$res = mysqli_num_rows($resnum);
                      $r = array();
                      while($result_arr = mysqli_fetch_assoc($resnum))
                      {
                      if($result_arr)
                         {
                            array_push($r,$result_arr);
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
               // echo "<pre>"; print_r($r2);
                 
                 $r = array();
                 foreach($r2 as $key)
                    {
                         $id= $key['following'];
                  
                     $query = "SELECT * FROM `registration` WHERE  user_id ='$id' AND `nickname`  like '$search_text%'";
                       $resnum = mysqli_query($con,$query);
                      //$res = mysqli_num_rows($resnum);
                       while($result_arr = mysqli_fetch_assoc($resnum))
                         {
                           if($result_arr)
                             {
                               array_push($r,$result_arr);
                             }
                         }
                     }
             // echo "<pre>";
           //  print_r($r2);
              }
              if($res > 0 )
              {
              if(!empty($r))
              {
              $result = array("response"=>array('code'=>'201','message'=>"Users Found Successfull",'data'=>$r));
                  print_r(json_encode($result));
              
              }else{
               $result = array("response"=>array('code'=>'200','message'=>" Users not Found !!.",'data'=>$r));
                    print_r(json_encode($result));
              }
              
                  
              }
              
    
             }
             else
                {
                   $result = array("response"=>array('code'=>'200','message'=>" User not found !!."));
                   print_r(json_encode($result));
                }
          } /* search code for national id  */
        
elseif(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])
&& isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text'])
&& isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type'])
&& isset($_REQUEST['nation_id']) && !empty($_REQUEST['nation_id'])
&& empty($_REQUEST['vocation']))
         {    $rnew = array();
            $user_id = $_REQUEST['user_id'];            
            $search_text = $_REQUEST['search_text'];
            $search_type = $_REQUEST['search_type'];
            $nation_id = $_REQUEST['nation_id'];
             $nation = explode(',',$nation_id);
            //print_r($nation);


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
                         foreach($nation as $data){
                          $query = "SELECT * FROM `registration` WHERE `nickname` like '$search_text%' AND `nationality_id` = '$data'";
                          $resnum = mysqli_query($con,$query);
                          //$res = mysqli_num_rows($resnum);
                          $r = array();
                          while($result_arr = mysqli_fetch_assoc($resnum))
                          {
                            //echo "<pre>";print_r($result_arr); 
                             //foreach($result_arr as $result123){
                         if($result_arr)
                             {

                                   array_push($rnew,$result_arr);
                               //$rnew[] =$result123;
                             } 
                          // }
                          }
                            
                      }
                      
                       }
                       if($search_type == 2)
                     {
                     echo   $sql2="SELECT `following` FROM `following_by_uid` WHERE `user_id` = '$user_id'";
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
                   // echo "<pre>"; print_r($r2);
                     
                     $r = array();
                     foreach($r2 as $key)
                        {
                             $id= $key['following'];
                      
                         $query = "SELECT * FROM `registration` WHERE  user_id ='$id' AND `nickname`  like '$search_text%'";
                           $resnum = mysqli_query($con,$query);
                          //$res = mysqli_num_rows($resnum);
                           while($result_arr = mysqli_fetch_assoc($resnum))
                             {
                               if($result_arr)
                                 {
                                   array_push($r,$result_arr);
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
elseif((isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))&& (isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text']))&& (isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type']))&& (isset($_REQUEST['vocation']) && !empty($_REQUEST['vocation'])) && (empty($_REQUEST['nation_id'])))
                    {    

                        $rnew = array();
                        $user_id = $_REQUEST['user_id'];            
                        $search_text = $_REQUEST['search_text'];
                        $search_type = $_REQUEST['search_type'];
                        $vocat = $_REQUEST['vocation'];
                        $voc = explode(',',$vocat); 

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
                    elseif((isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))&& (isset($_REQUEST['search_text']) && !empty($_REQUEST['search_text']))&& (isset($_REQUEST['search_type']) && !empty($_REQUEST['search_type']))&& (isset($_REQUEST['vocation']) && !empty($_REQUEST['vocation']))&& (empty($_REQUEST['nation_id']) && !empty($_REQUEST['nation_id'])))
                    {    

                        
                    }
                 else
                    {
$rnew = array();
                        $user_id = $_REQUEST['user_id'];            
                        $search_text = $_REQUEST['search_text'];
                        $search_type = $_REQUEST['search_type'];
                        $vocat = $_REQUEST['vocation'];
                        
                        $voc = explode(',',$vocat); 
                        
                        $nation_id = $_REQUEST['nation_id'];
                        $nation = explode(',',$nation_id);
                        //print_r($nation);
                       // echo "yesssssss";
                        
                        $voc1 = array_merge($voc,$nation);


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
                                        foreach($voc1 as $data){
                                            
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

                        //$result = array("response"=>array('code'=>'200','message'=>" Data not found !!."));
                        //print_r(json_encode($result));
                    }


?>