 <?php
include("config/config.php");
$user_id = $_POST['user_id'];

$content1     = isset($_POST['gnews_content']) ? $_POST['gnews_content'] : '';
$gnews_image1 = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
//$content      = preg_replace('/[^A-Za-z0-9\-\']/', '', $content1);
$content = mysqli_real_escape_string($con,$content1);

$type1="News";
$type         = 'Posted Good News';

$date = new DateTime(date());
$date->setTime(14, 55, 24);
$time = $date->format('Y-m-d H:i:s');

$qry    = "SELECT * FROM registration WHERE user_id = '$user_id'";
$resnum = mysqli_query($con, $qry);
$res    = mysqli_num_rows($resnum);


if ($res == 1) {
    
    if ($gnews_image1 != '') {
        $file_path = "uploads/";
        $file_path = $file_path . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
        if ($gnews_image1 != '') {
            
            $gnews_image1 = "asone_app/uploads/" . $gnews_image1;
            // $gnews_image1 = BASE_URL . "/asone_app/uploads/" . $gnews_image1;
        } else {
            $gnews_image1 = '';
        }
    }
    
    

    $sql ="INSERT INTO `post`( `type`, `user_id`, `content`, `post_image`, `like`, `coment`) 
    VALUES ('$type1','$user_id','$content','$gnews_image1','$like','$comment')";
    
   // $sql     = "INSERT INTO `goodnews` (`user_id`,  `gnews_content`, `gnews_image`) " . "VALUES ( '$user_id','$content', '$gnews_image1')";
    $results = mysqli_query($con, $sql);
    $last_id = $con->insert_id;
    
    if ($results) {
        
        /* for feed */
        $sql_f   = "SELECT `following` FROM `following_by_uid` WHERE `user_id`='$user_id'";
        $resnum2 = mysqli_query($con, $sql_f);
       
        $r_f     = array();
        while ($result_arr_g = mysqli_fetch_assoc($resnum2)) {
            if ($result_arr_g) {
                array_push($r_f, $result_arr_g);
            }
        }
        
        foreach ($r_f as $ff) {
           $follower_id   = $ff['following'];
            $foll_goodnews = "SELECT `user_id` FROM `registration` WHERE `user_id` = '$follower_id'";
            $resnum_g      = mysqli_query($con, $foll_goodnews);
            $r             = array();
            while ($result_arr_g = mysqli_fetch_assoc($resnum_g)) {
                if ($result_arr_g) {
                    array_push($r, $result_arr_g);
                }
                
            }
           // echo "<pre>";
           // print_r($r);
            $user_get_feed = $r[0]['user_id'];
            
            $sql_for_feed = "INSERT INTO `feeds_m`( `feedowner_id`,`action_owner_id`, `post_id`, `content`, `content_image`, `feed_type`) 
           VALUES ('$user_get_feed','$user_id','$last_id','$content','$gnews_image1','$type')";
            $resnum_g     = mysqli_query($con, $sql_for_feed);
            
        }
        /* for feed */
        
        
        
        $result = array(
            "response" => array(
                'code' => '201',
                'message' => "Good News added successfully!!",
                'data'=>array('last_id'=>$last_id, 'image' =>$gnews_image1) 
            )
        );
        print_r(json_encode($result));
    } else {
        $result = array(
            "response" => array(
                'code' => '200',
                'message' => "Query Failed"
            )
        );
        print_r(json_encode($result));
    }
} else {
    $result = array(
        "response" => array(
            'code' => '200',
            'message' => "User not found"
        )
    );
    print_r(json_encode($result));
}

?> 