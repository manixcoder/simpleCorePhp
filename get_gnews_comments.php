 <?php
include('config/config.php');

if (isset($_REQUEST['gnews_id']) && !empty($_REQUEST['gnews_id']))
 {
    
    $gnews_id = $_REQUEST['gnews_id'];

    $query  = "SELECT r. * , pc. * FROM gnews_comment pc, registration r WHERE pc.gnews_id ='$gnews_id' AND pc.user_id = r.user_id";
    $resnum = mysqli_query($con, $query);
    $res    = mysqli_num_rows($resnum);
    $r      = array();
    while ($result_arr = mysqli_fetch_assoc($resnum)) 
    {
        if ($result_arr) 
        {
            array_push($r, $result_arr);
        }
         else 
         {
            $result = array(
                "response" => array(
                    'code' => '200',
                    'message' => " No Comments"
                )
            );
            print_r(json_encode($result));
        }
    }
    
    
    if ($records = $resnum->num_rows > 0) {
        
        $result = array(
            "response" => array(
                'code' => '201',
                'message' => "Data found successfully .",
                'data' => $r
            )
        );
        print_r(json_encode($result));
    }
     else
      {
        $result = array(
            "response" => array(
                'code' => '200',
                'message' => " No Comments."
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
            'message' => "Data Not Found!!."
        )
    );
    print_r(json_encode($result));
} 