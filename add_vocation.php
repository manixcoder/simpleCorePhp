 <?php
include("config/config.php");

if (isset($_REQUEST['vocation']) && !empty($_REQUEST['vocation'])
&& isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id']))
 {
$user_id=$_REQUEST['user_id'];
$sql="SELECT * FROM `registration` WHERE `user_id`='$user_id'";
		$result1=mysqli_query($con, $sql);
		$count=mysqli_num_rows($result1);
		$res = mysqli_fetch_assoc($result1);
		if($res != 0)
		{
		
    $vocation = $_REQUEST['vocation'];
     $sql    = "SELECT * FROM `vacation` WHERE `vacation`='$vocation'";
    $result = mysqli_query($con, $sql);
    $res    = mysqli_fetch_assoc($result);
    if ($res == 0) {
        
        $sql     = "INSERT INTO `vacation` ( `vacation`,`user_id`) VALUES ( '$vocation','$user_id')";
        $results = mysqli_query($con, $sql);

 $last_id = mysqli_insert_id($con);
        if ($results) {
            $result = array(
                "response" => array(
                    'code' => '201',
                    'message' => " $vocation added as Vocation successfully!! ",
                 'data'=>array('vocation_id'=>$last_id)
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
                'message' => "Vocation allready added"
            )
        );
        print_r(json_encode($result));
    }

}
else
{
 $result = array(
        "response" => array(
            'code' => '200',
            'message' => "User Does not exists"
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
