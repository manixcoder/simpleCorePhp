<?php
include ('config/config.php');

$query = "SELECT * FROM `gender`";
$resnum = mysqli_query($con, $query);
$res = mysqli_num_rows($resnum);
$r = array();

while ($result_arr = mysqli_fetch_assoc($resnum))
	{
	if ($result_arr)
		{
		array_push($r, $result_arr);
		}
	  else
		{
		$result = array("response" => array('code' => '200','message' => "Gender not found"));
		print_r(json_encode($result));
		}
	}

if ($records = $resnum->num_rows > 0)
	{
	$result = array(
		"response" => array('code' => '201','message' => "Data found successfully ..",'data' => $r));
	print_r(json_encode($result));
	}
  else
	{
	$result = array("response" => array('code' => '200','message' => " There is no Gender."));
	print_r(json_encode($result));
	}
?>