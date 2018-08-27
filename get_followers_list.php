 <?php
include('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
    
    $user_id = $_REQUEST['user_id'];
     $r2 = array();
    
    //$query = "SELECT  `followers`, `username`, `profile_image`,`vocation` FROM `followers_by_uid` WHERE `user_id`='$user_id' ";
    $query  = "SELECT  `followers` FROM `followers_by_uid` WHERE `user_id`='$user_id'";
    $resnum = mysqli_query($con, $query);
    $res    = mysqli_num_rows($resnum);
    $r      = array();
    while ($result_arr = mysqli_fetch_assoc($resnum)) {
        if ($result_arr) {
            array_push($r, $result_arr);
        } else {
            $result = array(
                "response" => array(
                    'code' => '200',
                    'message' => "Follower  not found"
                )
            );
            print_r(json_encode($result));
        }
    }
    
   
    
    foreach ($r as $user) 
    {
        
    $vr_ur = $user[followers]; 
    
        
 $sql2="SELECT * FROM `registration` WHERE `user_id`='$vr_ur'";
     
      $resnum2 = mysqli_query($con, $sql2);
    
    while ($result_arr2 = mysqli_fetch_assoc($resnum2))
     {
        if ($result_arr2) {
            array_push($r2, $result_arr2);
        }
        
     }
    }
    if ($records = $resnum->num_rows > 0) {
        
        $result = array("response" => array('code' => '201','message' => "Data found successfully.",'data' => $r2));
        print_r(json_encode($result));
    } 
    else
     {
        $result = array("response" => array('code' => '200','message' => " No followers."));
        print_r(json_encode($result));
    }
}
 else
  {
    $result = array("response" => array('code' => '200','message' => "Data Not Found!!."));
    print_r(json_encode($result));
}

?> 