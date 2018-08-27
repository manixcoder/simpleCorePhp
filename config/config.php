<?php
	define('BASE_URL', 'http://localhost/');
	$serverName="localhost";
	$userName="userName";
	$password="password";
	$dbName="dataBaseName";
	$con=mysqli_connect($serverName,$userName,$password,$dbName);
	mysqli_select_db($con,$dbName);
	if($con)
	{
		//echo "Db connected";
	}
	else
	{
		echo "Connection Fail!";
	}
?>