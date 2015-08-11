<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "cmsc100";
	
	if($db = mysqli_connect($host, $username, $password, $database)
		or die("Unable to connect"));
?>