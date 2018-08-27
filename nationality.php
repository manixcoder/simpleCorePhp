<?php 
include ('config/config.php');

	$result = mysqli_query($con,"SELECT * FROM nationality") or die('Could not query');
	$emparray = array();
	while($row =mysqli_fetch_assoc($result))
	{
		$emparray[] = $row;
	}
	$result = array("response"=>array('code'=>'201','message'=>" Data found Successfully!!.",'Data'=>$emparray));
	print_r(json_encode($result));
	//echo json_encode($emparray);

  

?>