 <?php 

include("config/config.php");

if ((isset($_REQUEST['vocation']) && !empty($_REQUEST['vocation']))&&(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'] ))) {
    $vocation = $_REQUEST['vocation'];
  $user_id = $_REQUEST['user_id'];
    
    $sql    = "SELECT * FROM `vacation` WHERE `vacation`='$vocation' AND `user_id` = '$user_id' AND `added_by` = 'Front User'";
    $result = mysqli_query($con, $sql);
    $res    = mysqli_fetch_assoc($result);
    if ($res == 0) {
        
        $sql     = "INSERT INTO `vacation` ( `vacation` ,`user_id`,`added_by`) VALUES ( '$vocation','$user_id','Front User');";
        $results = mysqli_query($con, $sql);
        if ($results) {
            $result = array(
                "response" => array(
                    'code' => '201',
                    'message' => " $vocation added as Vocation successfully!! "
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
                'message' => "Vocation already added"
            )
        );
        print_r(json_encode($result));
    }
} else {
    $result = array(
        "response" => array(
            'code' => '200',
            'message' => "Data not found"
        )
    );
    print_r(json_encode($result));
} 