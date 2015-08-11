<?php
	require("db_connect.php");

		if(isset($_POST['username'])){
			$firstname = htmlspecialchars($_POST['firstname']);
			$lastname = htmlspecialchars($_POST['lastname']);
			$username = htmlspecialchars($_POST['username']);
			$email = htmlspecialchars($_POST['email']);
			$password = htmlspecialchars($_POST['password']);
			$accountType = htmlspecialchars($_POST['accountType']);

			if($accountType == 'Instructor'){
				$employeeNum = (int)$_POST['employeeNum'];

				$fetch = mysqli_query($db, "SELECT * FROM tb_instructor WHERE employeeNo = '{$employeeNum}'");
    			$row = mysql_num_rows($fetch);

				if($row>0){
					echo "Your employee number is already binded to an account. If you have concerns, please contact the developers. Thank you!";
					header("Location: try_again.php");
				}
				else{
					$instructor = mysqli_query($db, "INSERT INTO tb_instructor VALUES ('{$employeeNum}','{$username}','{$firstname}','{$lastname}','{$password}','{$email}', 'default.png' )");
					header("Location: success.php");
				} 
			}else{
				$studentNo = htmlspecialchars($_POST['studentNo']);
				
				$fetch = mysqli_query($db, "SELECT * FROM tb_student WHERE studentNo = '{$studentNo}'");
    			$row = mysql_num_rows($fetch);

				if($row>0){
					echo "Your student number is already binded to an account. If you have concerns, please contact the developers. Thank you!')";
					header("Location: try_again.php");
				}
				else {
					 $student = mysqli_query($db, "INSERT INTO tb_student VALUES ('{$studentNo}','{$username}','{$firstname}','{$lastname}','{$password}','{$email}', 'default.png')");
					header("Location: success.php");
				}
			}
		
			//echo $firstname." ".$lastname." ".$username." ".$email." ".$password." ".$accountType;
			
		}
		/*$duser = mysqli_query($db, "SELECT * FROM tb_student WHERE username = '".$username."'");
		$result1 = mysqli_num_rows($duser);
		$dstdnum = mysqli_quert($db, "SELECT * FROM tb_student WHERE studentNo = '".$studentNo."'");
		$result2 = mysqli_num_rows($dstdnum);*/
		
		
?>