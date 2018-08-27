<?php

include ('config/config.php');

if (isset($_REQUEST['gnews_id']) && !empty($_REQUEST['gnews_id']) 
&& isset($_REQUEST['opp_id']) && !empty($_REQUEST['opp_id']))
	{
	$gnews_id = $_REQUEST['gnews_id'];
	$opp_id = $_REQUEST['opp_id'];
	
	$sql = "SELECT * FROM `goodnews` WHERE `gnews_id`='$gnews_id'";
	$resnum = mysqli_query($con, $sql);
	$res1 = mysqli_num_rows($resnum);
	if ($res1 != 0) 
		{
		$sql2 = "SELECT `following` FROM `following_by_uid` WHERE `user_id` ='$opp_id'";
		$resnum2 = mysqli_query($con, $sql2);
		$r2 = array();
		while ($result_arr2 = mysqli_fetch_assoc($resnum2))
			{
			if ($result_arr2)
				{
				array_push($r2, $result_arr2);
				}
			 
			}

		$query = "SELECT r . * , pc . * FROM goodnews_like pc, registration r WHERE pc.gnews_id ='$gnews_id' AND pc.user_id = r.user_id GROUP BY pc.user_id";
		$resnum = mysqli_query($con, $query);
		$res = mysqli_num_rows($resnum);
		$r = array();
		while ($result_arr = mysqli_fetch_assoc($resnum))
			{
			if ($result_arr)
			{
				$ff = $result_arr['user_id'];
				$sql3 = "SELECT `following` FROM `following_by_uid` WHERE `following` ='$ff' and `user_id` = '$opp_id'";
				$resnum3 = mysqli_query($con, $sql3);
				$res3 = mysqli_num_rows($resnum3);
				$a = array();
				if ($res3 == 1)
					{
					$result_arr['is_follow'] = "true";				
					
					//array_push($result_arr,$a);
					

					}
				  else
				  {
				 $result_arr['is_follow'] = "false";
					
					//array_push($result_arr, $a);
					//array_push($result_arr,$a);

					}

				array_push($r, $result_arr);
				}
			
			}

		$result1 = array_intersect($r, $r2);
		
		//if ($records = $resnum->num_rows > 0)
		if ($res1 > 0)
			{

			// $result = array("response"=>array('code'=>'201','message'=>"Data found successfully ..",'data'=>$r));

			$result = array(
				"response" => array(
					'code' => '201',
					'message' => "Data found successfully ..",
					//'data' => $result1
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
					'message' => " There is not Good News."
				)
			);
			print_r(json_encode($result));
			}
		}else{
		$result = array("response" => array('code' => '200','message' => " Good News not fond."));
		print_r(json_encode($result));
		}
	}
  else
	{
	//echo "Data not found";
	$result = array(
		"response" => array(
			'code' => '200',
			'message' => " Data not found."
		)
	);
	print_r(json_encode($result));
	}
