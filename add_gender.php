 <?php
include("config/config.php");

if (isset($_REQUEST['gender']) && !empty($_REQUEST['gender'])) {

    $gender = $_REQUEST['gender'];
    
    
    $sql    = "SELECT * FROM `gender` WHERE `gender`='$gender'";
    $result = mysqli_query($con, $sql);
    $res    = mysqli_fetch_assoc($result);
    if ($res == 0) {
        
        $sql     = "INSERT INTO `gender`(`gender`) VALUES ('$gender')";
        $results = mysqli_query($con, $sql);
        if ($results) {
            $result = array(
                "response" => array(
                    'code' => '201',
                    'message' => " $gender added successfully!! "
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
                'message' => "Gender allready added"
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