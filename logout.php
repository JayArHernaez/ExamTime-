<?php

	session_start();
	include("db_connect.php");
	
	mysqli_close($db);
	session_destroy();
	header("Location: index.php");
?>