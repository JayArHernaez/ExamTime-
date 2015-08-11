<?php
	
	session_start();
	include("../db_connect.php");
	
  if(isset($_SESSION['role']) && $_SESSION['role'] == 'instructor'){
    $fetch = mysqli_query($db, "SELECT * FROM tb_instructor WHERE employeeNo = '{$_SESSION['empno']}'");
    $row = mysqli_fetch_assoc($fetch);
  }else{
    header("Location: ../index.php");
  }
  
  //deleting a student to a group
	if(isset($_POST['deleteStudent'])){
		$studentNo = htmlspecialchars($_POST['del-studentNo']);
    $group = htmlspecialchars($_POST['del-groupName']);

		$deleteStudent = mysqli_query($db,"DELETE FROM tb_in_group WHERE studentNo='{$studentNo}' AND groupname='{$group}'");
		

		if($deleteStudent){
			echo "<script>alert(\"Student Successfully Deleted!\")</script>";
		}else{
			echo "<script>alert(\"Deletion Unsuccessful.\")</script>";
			mysqli_error($db);
		}
   // header("Location: my_students.php");
	}	
//adding a student to a group
	if(isset($_POST['addS']) && !(trim($_POST['studentNo'])=== ' ')){
		$studentNo = htmlspecialchars($_POST['studentNo']);
		$groupname = htmlspecialchars($_POST['groupName']);
    $error = 0;

    //input validation
    if (!preg_match( '/^[2][0][0-9][0-9]-[0-9]{5}$/', $studentNo)) {
      $error++;
    }
    if (!preg_match('/^[A-Za-z0-9- ]{2,30}$/', $groupname)) {
      $error++;
    }

    if ($error<1) {
      $addS = mysqli_query($db, "INSERT INTO tb_in_group(studentNo, groupname) 
                          VALUES ('{$studentNo}','{$groupname}')");
      echo "<script>alert(\"Student Successfully Added!\")</script>";
     // header("Location: my_students.php");
    }
    else{
      echo "<script>alert(\"Enter a valid Student number or Groupname.\")</script>";
    }
	}	
  //adding a new group
  if(isset($_POST['addgrp']) && !(trim($_POST['Groupname'])=== ' ')){
    $groupname = htmlspecialchars($_POST['Groupname']);

    $err = 0;

    //input validation
    if (!preg_match('/^[A-Za-z0-9- ]{2,30}$/', $groupname)) {
      $err++;
    }

    if ($err<1) {
      $group = mysqli_query($db, "INSERT INTO tb_group (groupname, employeeNo) 
                          VALUES ('{$groupname}','{$_SESSION['empno']}')");
      
      if($group)echo "<script>alert(\"New Group Successfully Created!\")</script>";
      else echo "<script>alert(\"New Group Creation Failed!\")</script>";
      header("Location: my_students.php");
    }
    else{
      echo "<script>alert(\"Enter a valid Groupname.\")</script>";
    }

  }


?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="icon" type="img/png" href="../img/ebicon.png">
        <title>Examtime - Time to build exams!</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="../css/bootstrap_users.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../css/main.css">

        <script src="../js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
       
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src=../img/logo.png></img></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
		  
          <ul class="nav navbar-top-links navbar-right">
      			<li><a id=""><?="Welcome ".ucfirst($row['firstname'])."!" ?></a></li>
           <a href="../logout.php"><button name="logout" id="logout" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Log Out</button></a>
			
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
	
	
	
  <nav class="navbar navbar-inverse navbar-fixed-left" role="navigation">
      <div class="container" >
        <div id="list-group ">
          <ul class="nav nav-pills nav-stacked">
            <a ><img class="img-circle" src="<?='../uploads/'.$row['profilePic']?>" alt="Generic placeholder image" width="150" height="150" style="padding:20px;"></a>
            
            <li><a class="nav-stacked" href="instructor.php"><i class="fa fa-dashboard fa-fw "></i>  Dashboard</a></li>
            <li><a class="nav-stacked" href="profile.php"><i class="fa fa-user fa-fw"></i> My Profile</a></li>
            <li><a class="nav-stacked" href="my_exams.php"><i class="fa fa-file-text fa-fw"></i> My Exams</a></li>
            <li class="active"><a class="nav-stacked" href="my_students.php"><i class="fa fa-users fa-fw"></i> My Students</a></li>
            <li><a class="nav-stacked" href="achievements.php"><i class="fa fa-trophy fa-fw"></i> Achievements</a></li>
          </ul>    
        </div>
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container_user">
        <div class="panel panel-success">
           <div class="panel-heading">
              <h3 class="panel-title"><strong>My Students</strong></h3>
           </div>
           <div class="panel-body">
              <div class="alert alert-success" name="err-msg" hidden>
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Successful Operation!</strong> 
              </div>
              <div class="alert alert-info" role="alert">
                Here are the groups or classes that you created. You may Add and Delete a student or Create a new group!
              </div>

           <?php 
              $fetch = mysqli_query($db, "SELECT DISTINCT groupname FROM tb_group WHERE employeeNo = '".$_SESSION['empno']."'");
              $num_r = mysqli_num_rows($fetch);
              for ($i=0; $i < $num_r; $i++) { 
                $row = mysqli_fetch_assoc($fetch);
                ?>
                <table class="table table-hover table-bordered" id="student-exam-view">
                <thead>
                  <tr>
                    <th colspan="12"><?=$row['groupname']?></th>
                  <tr>
                  <tr>
                    <th class="col-md-3" style="text-align:center">Student No.</th>
                    <th class="col-md-5">Name</th>
                    <th class="col-md-4">Email Address</th>
                  </tr>
                </thead>
                <tbody>

                <?php

                $f = mysqli_query($db, "SELECT tb_student.studentNo,tb_student.firstname,tb_student.lastname,tb_student.email FROM tb_in_group RIGHT OUTER JOIN tb_student ON tb_in_group.studentNo=tb_student.studentNo WHERE tb_in_group.groupname = '".$row['groupname']."'");
                
                while($row2 = mysqli_fetch_assoc($f)){
                  echo "<tr><td><center>"; 
                  echo $row2['studentNo'];
                  echo "</center></td><td>";
                  echo $row2['firstname']." ".$row2['lastname'];
                  echo "</td><td>";
                  echo $row2['email'];
                  echo "</td></tr>";
                }//while loop
                ?>
                </tbody>
              </table>
                <?php
              }//forloop
           ?>
                             
           </div>
        </div>

        
        <br>
        <center>
        <button id="addStudent" class="btn btn-success"><i class="fa fa-user-plus"></i> Add Student</button>
        <button id="addGroup" class="btn btn-info"><i class="fa fa-plus"></i> Add Group</button>
		    <button id="deleteStudent" class="btn btn-danger"><i class="fa fa-user-times"></i> Delete Student</button>
      </center>
      <br><br>
      </div>
    </div>
	 

	<!--Modal form for Adding Student-->
    <div id="addStudent-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Add Student to a Group</h4>
              </div>
              <div class="modal-body">
                <form role="form" method="post" id="add-studtogrp-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-university"  ></i></span>
                        <input name="studentNo" id="add-studno" type="text" class="form-control" placeholder="Enter Student Number" maxlength="10" required/>
                    </div>
                    <p class="reg-error" id="grp-acct">* Please input a valid student number.</p>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-users"  ></i></span>
                        <input name="groupName" id="add-group" type="text" class="form-control" placeholder="Enter Group Name" maxlength="20" required/>
                    </div>
                   
          					<div class="modal-footer">
          						<button name="addStudent" type="submit" class="btn btn-success" id="addStudents">Add</button>
          					</div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Add Student-->

	<!--Modal form for Deleting Student-->
    <div id="deleteStudent-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Delete Student from a Group</h4>
              </div>
              <div class="modal-body">
                <form role="form" method="post" id="add-studtogrp-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-university"  ></i></span>
                        <input name="del-studentNo" id="add-studno" type="text" class="form-control" placeholder="Enter Student Number" maxlength="10" required/>
                    </div>
                    <p class="reg-error" id="grp-acct">* Please input a valid student number.</p>
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-users"  ></i></span>
                        <input name="del-groupName" id="add-group" type="text" class="form-control" placeholder="Enter Group Name" maxlength="20" required/>
                    </div>
                   
                    <div class="modal-footer">
                      <button name="deleteStudent" type="submit" class="btn btn-danger" id="addStudents">Delete</button>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Deleting Student-->
	
    <!--Modal form for Adding a Group-->
    <div id="addGroup-modal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Add Group</h4>
              </div>
              <div class="modal-body">
                <form role="form" method="post" id="add-group-form">
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-user-plus"  ></i></span>
                        <input name="Groupname" id="add-studno" type="text" class="form-control" placeholder="Enter Group Name" maxlength="20" required/>
                    </div>
                   
                    <div class="modal-footer">
                      <button name="addgrp" type="submit" class="btn btn-info" id="addStudents">New Group</button>
                    </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <!--END: Modal Form Add Group-->

   
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
        <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </body>
</html>
